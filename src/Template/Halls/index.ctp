
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



<div>
    <h1>Hall Of Fame</h1>
</div>


<div id="main-content">
    <table>
    <tbody>

    <?php 
    $nbrofPlayer=1;
    foreach ( $playerlist as $player ) {
        
        $nbrOfFighter = 1;
        //echo "<tr>";
        foreach ($fighterlist as  $fighter){
            
            if ($fighter->player_id == $player->id) {
               
               /* echo "<td>";
                echo $fighter->name;
                echo $nbrOfFighter;
                echo $nbrofPlayer;
                echo "</td>";*/
                $varArrayPlayerFighter['Player_'.$nbrofPlayer] = $nbrOfFighter;
                $nbrOfFighter++;
            } 
        }
       $nbrofPlayer++;
       //echo  "</tr>";
    }
    
    pr($varArrayPlayerFighter);
    ?>

    
    
        </tbody>
    </table>
    
    <?php 
    foreach ($fighterlist as  $fighter){
        $names[] =  $fighter->name;
        $skillsight[] = $fighter->skill_sight;
        $skillhealth[] = $fighter->skill_health;
        $skillstrength[] = $fighter->skill_strength;
        $fightersXp[] = $fighter->xp;
        $fighterslvl[] = $fighter->level;
    }

    ?>
    
    <div style="margin:auto;">
        <h3>Fighter Skills Chart</h3>
        <div id="skillchart" style="height:400px;width:400px;margin:auto;"></div>
    </div>

    
    <div style="margin:auto;">
        <h3>Fighter Average level</h3>
        <div id="levelchart" style="height:400px;width:400px;margin:auto;"></div>
    </div>
    
    <div style="margin:auto;">
        <h3>Number of fighter per Player</h3>
        <div id="pieChart" style="height:400px;width:400px;margin:auto;"></div>
    </div>
    
 <?php
/** KRA: mandatory files **/

echo $this->Html->script('JQPlot.shCore.min');
echo $this->Html->script('JQPlot.shBrushJScript.min');
echo $this->Html->script('JQPlot.shBrushXml.min');

/** KRA: additional plugins **/
echo $this->Html->script('JQPlot.jqplot.barRenderer.min');
echo $this->Html->script('JQPlot.jqplot.pieRenderer.min');
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


/** new array to pass **/
var xpResult = new Array();
var levelRresult = new Array();
var playerandFighter = new Array();

    for (var i = 0; i < namesArray.length; i++) {
        var temp1 = new Array();
        var temp2 = new Array();
        
        temp1.push(namesArray[i]);
        temp1.push(fightersXp[i]);
        
        temp2.push(namesArray[i]);
        temp2.push(fighterslvl[i]);
        
        xpResult.push(temp1);
        levelRresult.push(temp2);
    }
    
    alert(playersfigthers.length);
    
    for (var i = 1; i < playersfigthers.length+1; i++){
        var temp = new Array();
        
        temp.push('Player_'+i);
        temp.push(playersfigthers['Player_'+i]);
        playerandFighter.push(temp);
    }
    
 
 
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


        /*****************  Plot of fighter level  ************/    

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
                        speed: 2500
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
    
    /** plot number of fighter per player **/
  /* var data = [
    ['Heavy Industry', 12],['Retail', 9], ['Light Industry', 14], 
    ['Out of home', 16],['Commuting', 7], ['Orientation', 9]
  ];*/
  

  var plot2 = jQuery.jqplot ('pieChart', [playerandFighter], 
    {
      seriesDefaults: {
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Turn off filling of slices.
          fill: false,
          showDataLabels: true, 
          // Add a margin to seperate the slices.
          sliceMargin: 4, 
          // stroke the slices with a little thicker line.
          lineWidth: 5
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );

});


</script>

    
</div>

</section>