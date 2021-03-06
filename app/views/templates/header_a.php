
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= $data['title']; ?></title>
    <!-- Favicon-->
    <link rel="icon" type="image/png" href="<?= BASEURL; ?>/images/logo.png" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?= BASEURL; ?>/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?= BASEURL; ?>/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?= BASEURL; ?>/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="<?= BASEURL; ?>/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <link href="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?= BASEURL; ?>/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?= BASEURL; ?>/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?= BASEURL; ?>/css/themes/all-themes.css" rel="stylesheet" />

    <script src="<?= BASEURL; ?>/plugins/jquery/jquery.min.js"></script>
    

    <link rel="stylesheet" type="text/css" href="<?= BASEURL; ?>/assets/easyui/resource/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?= BASEURL; ?>/assets/easyui/resource/themes/icon.css">
    <script type="text/javascript" src="<?= BASEURL; ?>/assets/easyui/resource/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="<?= BASEURL; ?>/assets/easyui/datagrid-detailview.js"></script>
    <script type="text/javascript" src="<?= BASEURL; ?>/assets/js/datagrid-filter.js"></script>
    
    <script src="<?= BASEURL; ?>/plugins/jquery/jquery-ui.min.js"></script>
    <link href="<?= BASEURL; ?>/css/ui-autocomplete.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/plugins/multi-select/css/multi-select.css" rel="stylesheet">
    <script>
        var base_url = window.location.origin+'/ta-erp';
    </script>

    <style>
        .buttons-pdf, .buttons-print, .buttons-csv, .buttons-copy, .buttons-excel{
            display:none;
        }

        .spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            margin-left: -50px; /* half width of the spinner gif */
            margin-top: -50px; /* half height of the spinner gif */
            text-align:center;
            z-index:1234;
            overflow: auto;
            width: 100px; /* width of the spinner gif */
            height: 102px; /*hight of the spinner gif +2px to fix IE8 issue */
        }

        table.dataTable tr.group-end td {
            text-align: right;
            font-weight: normal;
        }

        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
            background-color: #9cadad;
            color: white;
            padding: 8px;
        }

        td.details-control {
            background: url('<?= BASEURL; ?>/images/show_detail.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('<?= BASEURL; ?>/images/close_detail.png') no-repeat center center;
        }

        tr.selected {
            background-color: #B0BED9 !important;
        }

        .dopdown-height {
            height:100px;
            overflow:scroll;
        }

        .card .header .header-dropdown {
            position: absolute;
            top: 10px;
            right: 15px;
            list-style: none;
        }

        .bootstrap-select.btn-group .dropdown-menu.inner {
            position: static;
            float: none;
            border: 0;
            padding: 0;
            margin: 0;
            border-radius: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            margin: 20px !important;
        }

        /* @media(max-width: 520px) {
            .navbar{
                display: none;
            }
        } */
    </style>
</head>

<body class="theme-red">
  <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= BASEURL; ?>"><?= $data['setting']['company']; ?></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <span><?= $_SESSION['usr']['name']; ?></span>
                            <i class="material-icons">keyboard_arrow_down</i>
                        </a>

                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?= BASEURL; ?>/user/changepassword"><i class="material-icons">person</i>Edit Password</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?= BASEURL; ?>/home/logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->

    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
         <!-- User Info -->
            <!-- <div class="user-info">
                <div class="image">
                    <img src="<?= BASEURL; ?>/images/aws-logo.png" width="48" height="48" alt="image" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['usr']['name']; ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?= BASEURL; ?>/user/changepassword"><i class="material-icons">person</i>Edit Password</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?= BASEURL; ?>/home/logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="active">
                        <a href="<?= BASEURL; ?>">
                            <i class="material-icons">home</i>
                            <span>Dashboard </span>
                        </a>
                    </li>

                    <!-- Master Data Menu -->
                    <li id="li_md">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">storage</i>
                            <span>Master Data</span>
                        </a>
                        <ul class="ml-menu">
                            <?php foreach($data['appmenu'] as $menu) : ?>
                                <?php if($menu['grouping'] === "master") : ?>
                                    <li>
                                        <a href="<?= BASEURL; ?>/<?= $menu['route']; ?>"><?= $menu['menu']; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <!-- End of Master Data Menu -->

                    <!-- Transaction Menu -->
                    <li id="li_tr">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">archive</i>
                            <span>Transaction</span>
                        </a>
                        <ul class="ml-menu">
                            <?php foreach($data['appmenu'] as $menu) : ?>
                                <?php if($menu['grouping'] === "transaction") : ?>
                                    <li>
                                        <a href="<?= BASEURL; ?>/<?= $menu['route']; ?>"><?= $menu['menu']; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <!-- End Of Transaction Menu -->

                    <!-- Reports Menu -->
                    <li id="li_rp">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">library_books</i>
                            <span>Reports</span>
                        </a>
                        <ul class="ml-menu">
                            <?php foreach($data['appmenu'] as $menu) : ?>
                                <?php if($menu['grouping'] === "report") : ?>
                                    <li>
                                        <a href="<?= BASEURL; ?>/<?= $menu['route']; ?>"><?= $menu['menu']; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <!-- End Of Reports Menu -->

                    <!-- Reports Menu -->
                    <li id="li_st">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">settings</i>
                            <span>Settings</span>
                        </a>
                        <ul class="ml-menu">
                            <?php foreach($data['appmenu'] as $menu) : ?>
                                <?php if($menu['grouping'] === "setting") : ?>
                                    <li>
                                        <a href="<?= BASEURL; ?>/<?= $menu['route']; ?>"><?= $menu['menu']; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <!-- End Of Reports Menu -->
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    <a href="javascript:void(0);">S - ERP Management System</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <script>
  
  $(function(){
    var _md = 0;
    var _tr = 0;
    var _rp = 0;
    var _st = 0;

    var datamenu = <?php echo json_encode($data['appmenu']); ?>;

    for (var i = datamenu.length - 1; i >= 0; --i) {
      if (datamenu[i].grouping == "master") {
        _md = _md+1;
      }else if (datamenu[i].grouping == "transaction") {
        _tr = _tr+1;
      }else if (datamenu[i].grouping == "report") {
        _rp = _rp+1;
      }else if (datamenu[i].grouping == "setting") {
        _st = _st+1;
      }
    }

    if(_md < 1){
      $('#li_md').hide();
    }

    if(_tr < 1){
      $('#li_tr').hide();
    }

    if(_rp < 1){
      $('#li_rp').hide();
    }

    if(_st < 1){
      $('#li_st').hide();
    }
    
  })
</script>