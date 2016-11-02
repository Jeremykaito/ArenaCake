
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
    //pr($varArrayPlayerFighter);
    // select all attributes of fighter to parse it later in javascript
    foreach ($fighterlist as  $fighter){
        $names[] =  $fighter->name;
        $skillsight[] = $fighter->skill_sight;
        $skillhealth[] = $fighter->skill_health;
        $skillstrength[] = $fighter->skill_strength;
        $fightersXp[] = $fighter->xp;
        $fighterslvl[] = $fighter->level;
    }

    ?>
    
    <div class="graphChart" style="margin:auto;">
        <h3>Niveau moyen et expérience des combattants.</h3>
        <div id="levelchart" ></div>
    </div>
    
    <div class="graphChart" style="margin:auto;">
        <h3>Tableau des capacités des combattants.</h3>
        <div id="skillchart" ></div>
    </div>
    
    <div class="graphChart" style="margin:auto;">
        <h3>Pourcentage des combattants de chaque joueur.</h3>
        <div id="pieChart" ></div>
    </div>
    
    <div class="graphChart" style="margin:auto;">
        <h3>Ratio Santé/level des combattans.</h3>
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
echo $this->Html->script('JQPlot.jqplot.bubbleRenderer.min');
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

var playersfigthers =<?php echo json_encode($varArrayPlayerFighter);?>;




/** new array to pass **/
var xpResult = new Array();
var levelRresult = new Array();
var playerandFighter = new Array();
var fighterLevel= new Array();

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
   
   
   //alert(playersfigthers.toString());
           /*var sizeA = Object.keys(playersfigthers).length;
    for (var i = 1; i < sizeA+1; i++){
        var temp = new Array();
        temp.push('Player_'+i);
        temp.push(playersfigthers['Player_'+i]);
        playerandFighter.push(temp);
    }*/
    
    
    for (var key in playersfigthers) {
    // skip loop if the property is from prototype
    //if (!playersfigthers.hasOwnProperty(key)) continue;

    var obj = playersfigthers[key];
   // alert(key + "" + obj);
  /* for (var prop in obj) {
        // skip loop if the property is from prototype
        if(!obj.hasOwnProperty(prop)) continue;
        // your code
        alert(prop + " = " + obj[prop]);
    }*/
         var temp = new Array();
        temp.push(key);
        temp.push(obj);
        playerandFighter.push(temp);
        
}
 
 /************** plot all chart ****/
$(document).ready(function(){
        /* Plot of  Fighter skills */ 
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


        /*****************  Plot of fighter exp and level  ************/    

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

 // var plot2 = jQuery.jqplot ('pieChart', [playerandFighter], 
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
  
 // alert(playerandFighter.toString());
  /** PLayer ratio **/
    
    //plot4 = $.jqplot('ratio',[arr],{
    plot4 = $.jqplot('ratio',[fighterLevel],{
        title: 'Player Level',
        seriesDefaults:{
            renderer: $.jqplot.BubbleRenderer,
            rendererOptions: {
                bubbleAlpha: 0.6,
                highlightAlpha: 0.8
            },
            shadow: true,
            shadowAlpha: 0.05
        }
    });   
  

});


</script>

    
</div>
</section>