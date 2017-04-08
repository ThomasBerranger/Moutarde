<?php

session_start();

require('connection.php');

if(isset($_SESSION['id']))
{

    $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();

    if ($userinfo['prenom']=="admin" && $userinfo['nom']=="admin") {

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Acceuil</title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
<![endif]-->
        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

        <!--[if lte IE 9]>
<link rel="stylesheet" href="assets/css/ace-ie.min.css" />
<![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="assets/js/ace-extra.min.js"></script>

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
<script src="assets/js/html5shiv.min.js"></script>
<script src="assets/js/respond.min.js"></script>
<![endif]-->
    </head>

    <body class="no-skin">
        <div id="navbar" class="navbar navbar-default          ace-save-state">
            <div class="navbar-container ace-save-state" id="navbar-container">
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
                </button>

                <div class="navbar-header pull-left">
                    <a href="accueil.php?id=<?php echo $_SESSION['id'] ?>" class="navbar-brand">
                        <small>
                            <i class="fa fa-leaf"></i>
                            French Motor Trip
                        </small>
                    </a>
                </div>

                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="light-blue dropdown-modal">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="background-color:none">Mon Compte<span class="caret"></span></a>
                          <ul class="dropdown-menu pull-left">
                              <li><a href="index.php?id=<?php echo $_SESSION['id'] ?>">Site</a></li>
                              <li role="separator" class="divider"></li>
                              <li><a href="deconnexion.php">Deconnexion</a></li>
                        </li>
                    </ul>
                </div>
            </div><!-- /.navbar-container -->
        </div>

        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try{ace.settings.loadState('main-container')}catch(e){}
            </script>

            <div id="sidebar" class="sidebar                  responsive                    ace-save-state">
                <script type="text/javascript">
                    try{ace.settings.loadState('sidebar')}catch(e){}
                </script>



                <ul class="nav nav-list">
                    <li class="active">
                        <a href="accueil.php?id=<?php echo $_SESSION['id'] ?>">
                            <i class="menu-icon fa fa-home"></i>
                            <span class="menu-text"> Acceuil </span>
                        </a>

                        <b class="arrow"></b>
                    </li>


                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-list"></i>
                            <span class="menu-text"> Tableaux </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li class="">
                                <a href="table_users.php?id=<?php echo $_SESSION['id'] ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Tableau utilisateurs
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="table_b_n.php?id=<?php echo $_SESSION['id'] ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Tableau reservation bretagne du nord
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="table_b_s.php?id=<?php echo $_SESSION['id'] ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Tableau reservation bretagne du sud
                                </a>

                                <b class="arrow"></b>
                            </li>

                            <li class="">
                                <a href="table_f_c.php?id=<?php echo $_SESSION['id'] ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Tableau reservations Franche-Comté
                                </a>

                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-pencil-square-o"></i>
                            <span class="menu-text"> Formulaires </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                            <li class="">
                                <a href="form_1.php?id=<?php echo $_SESSION['id'] ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Ajout / Suppression de réservation
                                </a>

                                <b class="arrow"></b>
                            </li>

                        </ul>
                    </li>

                    <li class="">
                        <a href="historique.php?id=<?php echo $_SESSION['id'] ?>">
                            <i class="menu-icon fa fa-list-alt"></i>
                            <span class="menu-text"> Historique </span>
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
          						<a href="#" class="dropdown-toggle">
          							<i class="menu-icon fa fa-calendar"></i>
          							<span class="menu-text"> Calendriers </span>

          							<b class="arrow fa fa-angle-down"></b>
          						</a>

          						<b class="arrow"></b>
                      <ul class="submenu">
          							<li class="">
          								<a href="calendrier_b_n.php?id=<?php echo $_SESSION['id'] ?>">
          									<i class="menu-icon fa fa-caret-right"></i>
          									Bretagne du nord
          								</a>

          								<b class="arrow"></b>
          							</li>
          							<li class="">
          								<a href="calendrier_b_s.php?id=<?php echo $_SESSION['id'] ?>">
          									<i class="menu-icon fa fa-caret-right"></i>
          									Bretagne du sud
          								</a>

          								<b class="arrow"></b>
          							</li>
          							<li class="">
          								<a href="calendrier_f_c.php?id=<?php echo $_SESSION['id'] ?>">
          									<i class="menu-icon fa fa-caret-right"></i>
          									Franche-Comté
          								</a>

          								<b class="arrow"></b>
          							</li>

          						</ul>
          					</li>

                    <li class="">
                        <a href="galerie.php?id=<?php echo $_SESSION['id'] ?>">
                            <i class="menu-icon fa fa-picture-o"></i>
                            <span class="menu-text"> Galerie </span>
                        </a>

                        <b class="arrow"></b>
                    </li>


                    <li class="">
           						<a href="#" class="dropdown-toggle">
           							<i class="menu-icon fa fa-file-o"></i>
           							<span class="menu-text">
           								 Page
           								<span class="badge badge-primary">1</span>
           							</span>
           							<b class="arrow fa fa-angle-down"></b>
           						</a>

           						<b class="arrow"></b>
           						<ul class="submenu">
           							<li class="">
           								<a href="index.php?id=<?php echo $_SESSION['id'] ?>">
           									<i class="menu-icon fa fa-caret-right"></i>
           									Index
           								</a>
           								<b class="arrow"></b>
           							</li>
           						</ul>
          					</li>

                </ul><!-- /.nav-list -->

                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>
            </div>

            <div class="main-content">
                <div class="main-content-inner">
                    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                        <ul class="breadcrumb">
                            <i class="ace-icon fa fa-home home-icon"></i>
                            <li class="active">Acceuil</li>
                        </ul><!-- /.breadcrumb -->

                    </div>

                    <div class="page-content">


                        <div class="page-header">
                            <h1>
                                Acceuil
                            </h1>
                        </div><!-- /.page-header -->

                        <h2>Bienvenue dans l'acceuil des administrateurs, sur votre gauche vous trouverez toutes les fonctions vous permettant d'administrer le site Frenchmotortrip.</h2>

                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder">Ace</span>
                            Application &copy; 2013-2014
                        </span>

                        &nbsp; &nbsp;
                        <span class="action-buttons">
                            <a href="#">
                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script src="assets/js/jquery-2.1.4.min.js"></script>

        <!-- <![endif]-->

        <!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
        <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
        </script>
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- page specific plugin scripts -->

        <!--[if lte IE 8]>
<script src="assets/js/excanvas.min.js"></script>
<![endif]-->
        <script src="assets/js/jquery-ui.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="assets/js/jquery.easypiechart.min.js"></script>
        <script src="assets/js/jquery.sparkline.index.min.js"></script>
        <script src="assets/js/jquery.flot.min.js"></script>
        <script src="assets/js/jquery.flot.pie.min.js"></script>
        <script src="assets/js/jquery.flot.resize.min.js"></script>

        <!-- ace scripts -->
        <script src="assets/js/ace-elements.min.js"></script>
        <script src="assets/js/ace.min.js"></script>

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            jQuery(function($) {
                $('.easy-pie-chart.percentage').each(function(){
                    var $box = $(this).closest('.infobox');
                    var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
                    var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
                    var size = parseInt($(this).data('size')) || 50;
                    $(this).easyPieChart({
                        barColor: barColor,
                        trackColor: trackColor,
                        scaleColor: false,
                        lineCap: 'butt',
                        lineWidth: parseInt(size/10),
                        animate: ace.vars['old_ie'] ? false : 1000,
                        size: size
                    });
                })

                $('.sparkline').each(function(){
                    var $box = $(this).closest('.infobox');
                    var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
                    $(this).sparkline('html',
                                      {
                        tagValuesAttribute:'data-values',
                        type: 'bar',
                        barColor: barColor ,
                        chartRangeMin:$(this).data('min') || 0
                    });
                });


                //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
                //but sometimes it brings up errors with normal resize event handlers
                $.resize.throttleWindow = false;

                var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
                var data = [
                    { label: "social networks",  data: 38.7, color: "#68BC31"},
                    { label: "search engines",  data: 24.5, color: "#2091CF"},
                    { label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
                    { label: "direct traffic",  data: 18.6, color: "#DA5430"},
                    { label: "other",  data: 10, color: "#FEE074"}
                ]
                function drawPieChart(placeholder, data, position) {
                    $.plot(placeholder, data, {
                        series: {
                            pie: {
                                show: true,
                                tilt:0.8,
                                highlight: {
                                    opacity: 0.25
                                },
                                stroke: {
                                    color: '#fff',
                                    width: 2
                                },
                                startAngle: 2
                            }
                        },
                        legend: {
                            show: true,
                            position: position || "ne",
                            labelBoxBorderColor: null,
                            margin:[-30,15]
                        }
                        ,
                        grid: {
                            hoverable: true,
                            clickable: true
                        }
                    })
                }
                drawPieChart(placeholder, data);

                /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
                placeholder.data('chart', data);
                placeholder.data('draw', drawPieChart);


                //pie chart tooltip example
                var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
                var previousPoint = null;

                placeholder.on('plothover', function (event, pos, item) {
                    if(item) {
                        if (previousPoint != item.seriesIndex) {
                            previousPoint = item.seriesIndex;
                            var tip = item.series['label'] + " : " + item.series['percent']+'%';
                            $tooltip.show().children(0).text(tip);
                        }
                        $tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
                    } else {
                        $tooltip.hide();
                        previousPoint = null;
                    }

                });

                /////////////////////////////////////
                $(document).one('ajaxloadstart.page', function(e) {
                    $tooltip.remove();
                });




                var d1 = [];
                for (var i = 0; i < Math.PI * 2; i += 0.5) {
                    d1.push([i, Math.sin(i)]);
                }

                var d2 = [];
                for (var i = 0; i < Math.PI * 2; i += 0.5) {
                    d2.push([i, Math.cos(i)]);
                }

                var d3 = [];
                for (var i = 0; i < Math.PI * 2; i += 0.2) {
                    d3.push([i, Math.tan(i)]);
                }


                var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
                $.plot("#sales-charts", [
                    { label: "Domains", data: d1 },
                    { label: "Hosting", data: d2 },
                    { label: "Services", data: d3 }
                ], {
                    hoverable: true,
                    shadowSize: 0,
                    series: {
                        lines: { show: true },
                        points: { show: true }
                    },
                    xaxis: {
                        tickLength: 0
                    },
                    yaxis: {
                        ticks: 10,
                        min: -2,
                        max: 2,
                        tickDecimals: 3
                    },
                    grid: {
                        backgroundColor: { colors: [ "#fff", "#fff" ] },
                        borderWidth: 1,
                        borderColor:'#555'
                    }
                });


                $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
                function tooltip_placement(context, source) {
                    var $source = $(source);
                    var $parent = $source.closest('.tab-content')
                    var off1 = $parent.offset();
                    var w1 = $parent.width();

                    var off2 = $source.offset();
                    //var w2 = $source.width();

                    if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
                    return 'left';
                }


                $('.dialogs,.comments').ace_scroll({
                    size: 300
                });


                //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
                //so disable dragging when clicking on label
                var agent = navigator.userAgent.toLowerCase();
                if(ace.vars['touch'] && ace.vars['android']) {
                    $('#tasks').on('touchstart', function(e){
                        var li = $(e.target).closest('#tasks li');
                        if(li.length == 0)return;
                        var label = li.find('label.inline').get(0);
                        if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
                    });
                }

                $('#tasks').sortable({
                    opacity:0.8,
                    revert:true,
                    forceHelperSize:true,
                    placeholder: 'draggable-placeholder',
                    forcePlaceholderSize:true,
                    tolerance:'pointer',
                    stop: function( event, ui ) {
                        //just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
                        $(ui.item).css('z-index', 'auto');
                    }
                }
                                    );
                $('#tasks').disableSelection();
                $('#tasks input:checkbox').removeAttr('checked').on('click', function(){
                    if(this.checked) $(this).closest('li').addClass('selected');
                    else $(this).closest('li').removeClass('selected');
                });


                //show the dropdowns on top or bottom depending on window height and menu position
                $('#task-tab .dropdown-hover').on('mouseenter', function(e) {
                    var offset = $(this).offset();

                    var $w = $(window)
                    if (offset.top > $w.scrollTop() + $w.innerHeight() - 100)
                        $(this).addClass('dropup');
                    else $(this).removeClass('dropup');
                });

            })
        </script>
    </body>
</html>

<?php
}
else
{
header("Location: index.php");
}
}
else
{
header("Location: index.php");
}
?>
