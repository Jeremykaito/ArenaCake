
<section id="HallOfFame">
<!--[if lt IE 9]>                                          
<?php  echo $this->Html->script('excanvas.min.js');?>
<![endif]-->

<?php

echo $this->Html->css('jqplot.1.0.9/jquery.jqplot.min.css');
echo $this->Html->css('jqplot.1.0.9/shThemejqPlot.min.css');
echo $this->Html->css('jqplot.1.0.9/shCoreDefault.min.css');
echo $this->Html->css('Halls/hallofFame.css');

/** KRA :JQplot Plugins **/
echo $this->Html->script('jquery.min.js');
echo $this->Html->script('jqplot.1.0.9/jquery.jqplot.min.js');
?>



<div>
    <h1>Hall Of Fame</h1>
</div>


<div id="main-content">
    <table>
    <tbody>

    <?php 
    
    foreach ( $playerlist as $player ) {
        
        echo "<tr>";
        foreach ($fighterlist as  $fighter){
            
            if ($fighter->player_id == $player->id) {
               
                echo "<td>";
                echo $fighter->name;
                //echo $this->Html->image('sprites/rogue.png', ['alt' => 'perso']);
                echo "</td>";
            }   
        }
       echo  "</tr>";
    }
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
        <div id="levelchart" style="height:300px;width:400px;margin:auto;"></div>
    </div>
    
    <div style="margin:auto;">
        <h3>Number of fighter per Player</h3>
        <div id="pieChart" style="height:400px;width:400px;margin:auto;"></div>
    </div>
    
 <?php
/** KRA: mandatory files **/

echo $this->Html->script('jqplot.1.0.9/shCore.min.js');
echo $this->Html->script('jqplot.1.0.9/shBrushJScript.min.js');
echo $this->Html->script('jqplot.1.0.9/shBrushXml.min.js');

/** KRA: additional plugins **/
echo $this->Html->script('jqplot.1.0.9/jqplot.barRenderer.min.js');
echo $this->Html->script('jqplot.1.0.9/jqplot.pieRenderer.min.js');
echo $this->Html->script('jqplot.1.0.9/jqplot.categoryAxisRenderer.min.js');
echo $this->Html->script('jqplot.1.0.9/jqplot.pointLabels.min.js');

?>   

<script>
 
var namesArray      =<?php echo json_encode($names );?>;
var skillhealth     =<?php echo json_encode($skillhealth );?>;
var skillsight      =<?php echo json_encode($skillsight );?>;
var skillstrength   =<?php echo json_encode($skillstrength );?>;
var fightersXp      =<?php echo json_encode($fightersXp );?>;
var fighterslvl     =<?php echo json_encode($fighterslvl );?>;

/** new array to pass **/
var xpResult = new Array();
var levelRresult = new Array();

    for (var i = 0; i < namesArray.length; i++) {
        var temp1 = new Array();
        var temp2 = new Array();
        temp1.push(namesArray[i].toString());
        temp1.push(namesArray[i].toString());
        
        temp2.push(parseInt(fightersXp[i]));
        temp2.push(parseInt(fighterslvl[i]));
        
        xpResult.push(temp1);
        levelRresult.push(temp2);
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
            // These options will set up the x axis like a category axis.
            xaxis: {
                tickInterval: 2,
                drawMajorGridlines: false,
                drawMinorGridlines: true,
                drawMajorTickMarks: false,
                rendererOptions: {
                tickInset: 1,
                minorTicks: 1,
                label:"Fighter's Name",
            }
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
                    // align the ticks on the y2 axis with the y axis.
                    alignTicks: true,
                    forceTickAt0: true
                }
            }
        }
    });
    
    /** plot number of fighter per player **/
    var s1 = [['Sony',7], ['Samsumg',13.3], ['LG',14.7], ['Vizio',5.2], ['Insignia', 1.2]];
         
    var plot3 = $.jqplot('pieChart', [s1], {
        grid: {
            drawBorder: false, 
            drawGridlines: false,
            background: '#ffffff',
            shadow:false
        },
        axesDefaults: {
             
        },
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions: {
                showDataLabels: true
            }
        },
        legend: {
            show: true,
            rendererOptions: {
                numberRows: 1
            },
            location: 's'
        }
    }); 

});


</script>

    
</div>

</section>