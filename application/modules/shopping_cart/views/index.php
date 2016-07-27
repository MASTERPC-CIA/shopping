<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <title>Master PC</title>
      
    <?php
        echo input(array('type'=>'hidden','id'=>'main_path','value'=>  base_url()));    
        $css = array(
                base_url('resources/css/style.css'),
                base_url('resources/css/style/style.css'),
                base_url('resources/css/style/bootstrap.min.css'),
                base_url('resources/css/style/font-awesome.min.css'),
                base_url('resources/css/style/owl.carousel.css'),
                base_url('resources/css/style/responsive.css'), 
                base_url('resources/css/style/menu.css'), 
                 
                 
                base_url('resources/fonts/css'),
                base_url('resources/fonts/css(1)'),
                base_url('resources/fonts/css(2)'), 
                'http://fonts.googleapis.com/css?family=Lobster',
        );
        echo csslink($css);    
    
        $js = array(
           
            base_url('resources/js/portal/portal/jquery.easing.1.3.min.js'),
                base_url('resources/js/portal/jquery.min.js'),
                base_url('resources/js/portal/jquery.sticky.js'),
                base_url('resources/js/portal/owl.carousel.min.js'),
                base_url('resources/js/portal/main.js'),
                base_url('resources/js/portal/bootstrap.min.js'),
                base_url('resources/js/portal/bootstrap-modal.js'),
                base_url('resources/js/portal/jquery.js'),
                base_url('resources/js/portal/nav.js'),
                base_url('resources/js/portal/nav-hover.js'),
        );
        echo jsload($js);        
//    ?>
    </head>
    <body>
    <?php $this->load->view('portal/navigator');?>
	
        <!-- Start Logo Section -->
        <section id="logo-section" class="text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="logo text-center">
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Logo Section -->
        
        <!-- End Main Body Section -->
	    
      <div class="maincontent-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
		
        <?php $this->load->view('portal/section_right');?>
		      </div>
        </div>
    </div>
       <?php $this->load->view('portal/menu_top'); ?>
       <?php $this->load->view('portal/footer'); ?>
       <?php
			
            if(!$this->user->id){
                $this->load->view('portal/login_section');
            }
			
            $this->load->view('portal/contacts');
            $this->load->view('portal/services');
            $this->load->view('portal/about_us');
	
         ?>
        
    </body>
    
</html>