
<section id="HallOfFame">
<!--[if lt IE 9]>                                          
<?php  echo $this->Html->script('excanvas.min.js');?>
<![endif]-->

<?php

echo $this->Html->css('JQPlot.jquery.jqplot.min');
echo $this->Html->css('JQPlot.shThemejqPlot.min');
echo $this->Html->css('JQPlot.shCoreDefault.min');
echo $this->Html->css('Halls/hallofFame.css');

/** KRA :JQplot Plugins **/
echo $this->Html->script('jquery.min.js');
echo $this->Html->script('JQPlot.jquery.jqplot.min');
?>


<div id="main-content">
    <div>
        <h2>Hall Of Fame</h2>
    </div>
    <?php 
    //create an object with the player and the fighter he owns
    $nbrofPlayer=1;
    foreach ( $playerlist as $player ) {
        $nbrOfFighter = 1;
        foreach ($fighterlist as  $fighter){  
            if ($fighter->player_id == $player->id) {
                $varArrayPlayerFighter['Player_'.$nbrofPlayer] = $nbrOfFighter;
                $nbrOfFighter++;
            } 
        }
       $nbrofPlayer++;
    }
    // select all attributes of fighter to parse it later in javascript
    foreach ($fighterlist as  $fighter){
        $names[]        =  $fighter->name;
        $skillsight[]   = $fighter->skill_sight;
        $skillhealth[]  = $fighter->skill_health;
        $skillstrength[]= $fighter->skill_strength;
        $fightersXp[]   = $fighter->xp;
        $fighterslvl[]  = $fighter->level;
    }

    ?>
    <!-- Chart section -->
    <div class="graphChart" style="margin:auto;">
        <h3>Niveau moyen et expérience des combattants.</h3>
        <div id="levelchart" ></div>
    </div>
    <div class="graphChart" style="margin:auto;">
        <h3>Tableau des capacités des combattants.</h3>
        <div id="skillchart" ></div>
    </div>
    <div class="graphChart" style="margin:auto;">
        <h3>Proportion des combattants dans l'arène.</h3>
        <div id="pieChart" ></div>
    </div>
    <div class="graphChart" style="margin:auto;">
        <h3>Pourcentage d'évènements par combattant.</h3>
        <div id="ratio" ></div>
    </div>
    
 <?php
/** KRA: mandatory files **/
echo $this->Html->script('JQPlot.shCore.min');
echo $this->Html->script('JQPlot.shBrushJScript.min');
echo $this->Html->script('JQPlot.shBrushXml.min');
/** KRA: additional plugins **/
echo $this->Html->script('JQPlot.jqplot.barRenderer.min');
echo $this->Html->script('JQPlot.jqplot.pieRenderer.min');
echo $this->Html->script('JQPlot.jqplot.donutRenderer.min');
echo $this->Html->script('JQPlot.jqplot.categoryAxisRenderer.min');
echo $this->Html->script('JQPlot.jqplot.pointLabels.min');
?>   

<script>
 
var namesArray      =<?php echo json_encode($names );?>;
var skillhealth     =<?php echo json_encode($skillhealth );?>;
var skillsight      =<?php echo json_encode($skillsight );?>;
var skillstrength   =<?php echo json_encode($skillstrength );?>;
var fightersXp      =<?php echo json_encode($fightersXp );?>;
var fighterslvl     =<?php echo json_encode($fighterslvl );?>;

var playersfigthers     =<?php echo json_encode($varArrayPlayerFighter);?>;
var varEventperFighter  =<?php echo json_encode($varEventperFighter);?>;

 /**********************************************/
 /****Contruct parameters to pass to JQplot ****/
 /**********************************************/
 
var xpResult = new Array();
var levelRresult = new Array();
var playerandFighter = new Array();
var fighterLevel= new Array();
var eventsAndFighter = new Array();

    for (var i = 0; i < namesArray.length; i++) {
        var temp1 = new Array();
        var temp2 = new Array();
        
        var temp3= new Array();
        
        temp1.push(namesArray[i]);
        temp1.push(fightersXp[i]);
        
        temp2.push(namesArray[i]);
        temp2.push(fighterslvl[i]);
        
        var realLevel = fighterslvl[i]/4;
        temp3.push(fightersXp[i]);
        temp3.push(fighterslvl[i]);
        temp3.push(1+realLevel);
        temp3.push(namesArray[i]);
        
        xpResult.push(temp1);
        levelRresult.push(temp2);
        fighterLevel.push(temp3);
    }
   
    for (var key in playersfigthers) {
        var obj = playersfigthers[key];
        var temp = new Array();
        temp.push(key);
        temp.push(obj);
        playerandFighter.push(temp);
        
    }
 
    for (var oKey in varEventperFighter){
        var obj = varEventperFighter[oKey];
        var tempu = new Array();
        tempu.push(oKey);
        tempu.push(obj);
        eventsAndFighter.push(tempu);
    }
/**********************************************/
 /************** plot all charts **************/
/**********************************************/
$(document).ready(function(){
        
    /****** 1)  Plot of  Fighter skills ************/ 
    plot2 = $.jqplot('skillchart', [skillhealth, skillsight,skillstrength], {
        seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            pointLabels: { show: true }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: namesArray,
                label:"Fighter's Name",
                labelRenderer: $.jqplot.CanvasAxisLabelRenderer
            },
            yaxis:{
                label:"Skill level",
                labelRenderer: $.jqplot.CanvasAxisLabelRenderer
            }
        },
        legend: {
            show: true,
            location: 'e',
            placement: 'outside',
            rendererOptions: {
            numberRows: 1
            },
            labels:['health','sight','strength']
        }   
    });

    $('#skillchart').bind('jqplotDataHighlight', 
        function (ev, seriesIndex, pointIndex, data) {
            $('#info2').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
        }
    ); 
    $('#skillchart').bind('jqplotDataUnhighlight', 
        function (ev) {
            $('#info2').html('Nothing');
        }
    );

    /**********2)  Plot of fighter exp and level  ************/    
    plot1 = $.jqplot("levelchart", [  fighterslvl, fightersXp], {
        animate: true,
        animateReplot: true,
        series:[
            {
                pointLabels: {
                    show: true
                },
                renderer: $.jqplot.BarRenderer,
                showHighlight: false,
                yaxis: 'y2axis',
                rendererOptions: {
                    animation: {
                        speed: 3000
                    },
                    barWidth: 15,
                    barPadding: -15,
                    barMargin: 0,
                    highlightMouseOver: false
                }
            }, 
            {
                rendererOptions: {
                    animation: {
                        speed: 2000
                    }
                }
            }
        ],
        axesDefaults: {
            pad: 0
        },
        axes: {
            xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: namesArray,
                    label:"Fighter's Name",
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer
            },
            yaxis: {
                label:"exp.",
                rendererOptions: {
                    forceTickAt0: true
                }
            },
            y2axis: {
                label:"level",
                rendererOptions: {
                    alignTicks: true,
                    forceTickAt0: true
                }
            }
        }
    });

    /***** 3) Pie render for porpotion  ******/
     var plot2 = jQuery.jqplot ('pieChart', [playerandFighter], 
       {
         seriesDefaults: {
           renderer: jQuery.jqplot.PieRenderer, 
           rendererOptions: {
             fill: false,
             showDataLabels: true, 
             sliceMargin: 4, 
             lineWidth: 5
           }
         }, 
         legend: { show:true, location: 'e' }
       }
     );
  
    /***** 4) Donut Chart for player events **************/
    var plot4 = jQuery.jqplot('ratio', [eventsAndFighter], {
    seriesDefaults: {
      renderer:$.jqplot.DonutRenderer,
      rendererOptions:{
        sliceMargin: 3,
        startAngle: -90,
        showDataLabels: true,
        dataLabels: 'value',
        totalLabel:true
      }
    },
    legend: { show:true, location: 'e' }
  });
 
 /***************************************************************/
 /**************************** End of all charts ****************/
 /***************************************************************/
 
});
</script>

    
</div>
</section>