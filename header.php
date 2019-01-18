<? if (!$csv){ ?>
<!DOCTYPE html>
<html lang="en">
<?}
$time_start = microtime(true); 
include("db_details.php");
 $link = mysqli_connect($db_location,$db_user,$db_pass);
$db_selected = mysqli_select_db('plasmogmdb', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysqli_error());
}
	function time_passed($timestamp)
{
    $diff = time() - (int)$timestamp;

    if ($diff == 0) 
         return 'just now';

    $intervals = array
    (
        1                   => array('year',    31556926),
        $diff < 31556926    => array('month',   2628000),
        $diff < 2629744     => array('week',    604800),
        $diff < 604800      => array('day',     86400),
        $diff < 86400       => array('hour',    3600),
        $diff < 3600        => array('minute',  60),
        $diff < 60          => array('second',  1)
    );

     $value = floor($diff/$intervals[1][1]);
     return $value.' '.$intervals[1][0].($value > 1 ? 's' : '').' ago';
}
if (!$csv){
?>
<head>

    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link href="/css/lightbox.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PhenoPlasm</title>

    <!-- Bootstrap Core CSS -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<style>
  
.corner-ribbon{
  width: 200px;
  background: #e43;
  position: absolute;
  top: 25px;
  left: -50px;
  text-align: center;
  line-height: 50px;
  letter-spacing: 1px;
  color: #f0f0f0;
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
}

/* Custom styles */

.corner-ribbon.sticky{
  position: fixed;
}

.corner-ribbon.shadow{
  box-shadow: 0 0 3px rgba(0,0,0,.3);
}

/* Different positions */

.corner-ribbon.top-left{
  top: 25px;
  left: -50px;
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
}

.corner-ribbon.top-right{
  top: 25px;
  right: -50px;
  left: auto;
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
z-index:2000;
}

.corner-ribbon.bottom-left{
  top: auto;
  bottom: 25px;
  left: -50px;
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
}

.corner-ribbon.bottom-right{
  top: auto;
  right: -50px;
  bottom: 25px;
  left: auto;
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
}

/* Colors */

.corner-ribbon.white{background: #f0f0f0; color: #555;}
.corner-ribbon.black{background: #333;}
.corner-ribbon.grey{background: #999;}
.corner-ribbon.blue{background: #39d;}
.corner-ribbon.green{background: #2c7;}
.corner-ribbon.turquoise{background: #1b9;}
.corner-ribbon.purple{background: #95b;}
.corner-ribbon.red{background: #e43;}
.corner-ribbon.orange{background: #e82;}
.corner-ribbon.yellow{background: #ec0;}
</style>
<!-- <div class="corner-ribbon top-right sticky blue"><a href="http://michaeleisen.org/petition/" style="color:white">Support Plan S!</a></div>
-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65298-20', 'auto');
  ga('send', 'pageview');

</script>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="/phenoplasm.png"></a>
            </div>
            <!-- /.navbar-header -->

            
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <form style="display:inline;padding:0;margin:0;" action="singlesearch.php" method="get"><div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Gene ID / name" name="gene">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submi9t">
                                    <i class="fa fa-search"></i>
                                </button>								
                            </span>
							
                            </div></form>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="/index.php"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>
               
                        <li>
                            <a href="/batch.php"><i class="fa fa-table fa-fw"></i> Batch search</a>
                        </li>
						  <li>
                            <a href="/advanced.php"><i class="fa fa-list fa-fw"></i> Advanced search</a>
                        </li>

			<li>
                            <a href="/stats.php"><i class="fa fa-signal fa-fw"></i> Statistics</a>
                        </li>
						<li>
                            <a href="/about.php"><i class="fa fa-info-circle fa-fw"></i> About</a>
                        </li>
                        <!--<li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> About</a>
                        </li>
						<li>
                            <a href="forms.html"><i class="fa fa-wrench fa-fw"></i> Stats</a>
                        </li>-->
                       
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<? }?>
