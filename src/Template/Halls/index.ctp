
<section id="HallOfFame">
<!--[if lt IE 9]>                                          
<?php  echo $this->Html->script('excanvas.min.js');?>
<![endif]-->

<?php

echo $this->Html->css('jqplot.1.0.9/jquery.jqplot.min.css');
echo $this->Html->css('jqplot.1.0.9/shThemejqPlot.min.css');
echo $this->Html->css('jqplot.1.0.9/shCoreDefault.min.css');

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
        <div id="level" style="height:400px;width:400px;margin:auto;"></div>
    </div>
    
 <?php
/** KRA: mandatory files **/

echo $this->Html->script('jqplot.1.0.9/shCore.min.js');
echo $this->Html->script('jqplot.1.0.9/shBrushJScript.min.js');
echo $this->Html->script('jqplot.1.0.9/shBrushXml.min.js');

/** KRA: additional plugins **/
echo $this->Html->script('jqplot.1.0.9/jqplot.barRenderer.min.js');
echo $this->Html->script('jqplot.1.0.9/jqplot.categoryAxisRenderer.min.js');
echo $this->Html->script('jqplot.1.0.9/jqplot.pointLabels.min.js');

?>   

<script>
 
var namesArray      =<?php echo json_encode($names );?>;
var skillhealth     =<?php echo json_encode($skillhealth );?>;
var skillsight      =<?php echo json_encode($skillsight );?>;
var skillstrength   =<?php echo json_encode($skillstrength );?>;
 
    
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


        /* Plot of fighter level*/    

        var s1 = [[2002, 112000], [2003, 122000], [2004, 104000], [2005, 99000], [2006, 121000], 
    [2007, 148000], [2008, 114000], [2009, 133000], [2010, 161000], [2011, 173000]];
    var s2 = [[2002, 10200], [2003, 10800], [2004, 11200], [2005, 11800], [2006, 12400], 
    [2007, 12800], [2008, 13200], [2009, 12600], [2010, 13100]];
 
    plot1 = $.jqplot("levelchart", [s2, s1], {
        animate: true,
        animateReplot: true,
        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },
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
                tickInterval: 1,
                drawMajorGridlines: false,
                drawMinorGridlines: true,
                drawMajorTickMarks: false,
                rendererOptions: {
                tickInset: 0.5,
                minorTicks: 1
            }
            },
            yaxis: {
                tickOptions: {
                    formatString: "$%'d"
                },
                rendererOptions: {
                    forceTickAt0: true
                }
            },
            y2axis: {
                tickOptions: {
                    formatString: "$%'d"
                },
                rendererOptions: {
                    // align the ticks on the y2 axis with the y axis.
                    alignTicks: true,
                    forceTickAt0: true
                }
            }
        },
        highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: 'y',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
        }
    });
   

});


</script>

    
</div>

</section>
