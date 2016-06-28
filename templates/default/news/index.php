<?php get_header(); ?>

    <div class="main-container" id="main-container">
        
        <?php get_template('sidebar.php'); ?>

        <div class="main-content">
            <div class="main-content-inner">
                <div class="breadcrumbs" id="breadcrumbs">
                    <script type="text/javascript">
                        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                    </script>

                    <ul class="breadcrumb">
                        <li>
                            <i class="ace-icon fa fa-home home-icon"></i>
                            <a href="#">Home</a>
                        </li>
                        <li class="active">Noticias</li>
                    </ul><!-- /.breadcrumb -->

                    <div class="nav-search" id="nav-search">
                        <form class="form-search">
                            <span class="input-icon">
                                <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                        </form>
                    </div><!-- /.nav-search -->
                </div>

                <div class="page-content">
                    
                    <?php get_template('ace-settings-container.php') ?>

                    <div class="page-header">
                        <h1>
                            Noticias
                            <small>
                                <i class="ace-icon fa fa-angle-double-right"></i>
                                Principal
                            </small>
                        </h1>
                    </div><!-- /.page-header -->

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="alert alert-block alert-success hide">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>

                                <i class="ace-icon fa fa-check green"></i>

                                Welcome to
                                <strong class="green">
                                    Ace
                                    <small>(v1.3.3)</small>
                                </strong>, alguma coisa em russo
                            </div>

                            <div class="">
                                
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs navbar-fixed-top" role="tablist">
                                <?php $is_active = 'active'; ?>
                                <?php foreach ($channels as $channel => $item): ?>
                                    <li role="presentation" class="<?php echo $is_active; $is_active=''; ?>">
                                        <a href="#tab_news_<?php echo $channel ?>" aria-controls="tab_news_<?php echo $channel ?>" role="tab" data-toggle="tab"><?php echo $item['title'] ?></a>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    
                                    <?php $is_active = 'active'; ?>
                                    <?php foreach ($posts as $channel => $items): ?>

                                        <div role="tabpanel" class="tab-pane <?php echo $is_active; $is_active=''; ?>" id="tab_news_<?php echo $channel ?>">
                                            <!-- <h2><?php echo $channels[$channel]['title'] ?></h2> -->
                                            <div class="row">
                                                
                                            <?php if (!empty($items)): ?>
                                                
                                            <?php foreach ($items as $item): ?>
                                                <?php 
                                                    $image_url = $item['image_url'];
                                                    if (empty($item['image_url'])) 
                                                        $image_url = get_template_url().'/assets/images/noimage_544x258.png';
                                                ?>
                                                <div class="col-sm-6 col-md-3">
                                                    <div class="thumbnail" style="min-height:350px;">
                                                        <a href="<?php echo $item['url']; ?>" title="<?php echo $item['title']; ?>">
                                                            <img src="<?php echo $image_url ?>" alt="<?php echo $item['title'] ?>">
                                                            <div class="caption">
                                                                <h4><?php echo $item['title']; ?></h4>
                                                                <p>
                                                                    <?php echo $item['short_description']; ?>
                                                                </p>
                                                                <p>
                                                                    <abbr class="pull-left" title="<?php echo date('d/m/Y H:i', $item['modified']) ?>">
                                                                    <?php 
                                                                        \Moment\Moment::setLocale('pt_BR');
                                                                        echo (new \Moment\Moment('@'.$item['modified'], 'CET'))->calendar(); 
                                                                    ?>
                                                                    </abbr>
                                                                </p>
                                                                <p>
                                                                    <a href="<?php echo $item['url']; ?>" class="btn btn-default btn-sm btn-link pull-right" role="button">Saiba mais</a>
                                                                </p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                            <?php else: ?>
                                                <div class="col-md-12">Ops! Nada por aqui. <?php echo $channels[$channel]['title'] ?></div>
                                            <?php endif ?>
                                            </div>
                                        </div>
                                    <?php endforeach ?>

                                </div> <!-- end tab-content -->
                            </div><!-- /.row -->

                            <!-- PAGE CONTENT ENDS -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.page-content -->
            </div>
        </div><!-- /.main-content -->

<?php get_footer(); ?>