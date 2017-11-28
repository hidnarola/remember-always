<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php
        $this->load->view('Templates/default_header');
        ?>
        <script type="text/javascript">
            //Set common javascript vairable
            var site_url = "<?php echo site_url() ?>";
            var base_url = "<?php echo base_url() ?>";
        </script>
        <noscript>
        <META HTTP-EQUIV="Refresh" CONTENT="0;URL=js_disabled">
        </noscript>    
    </head>
    <body>
        <!-- Page container -->
        <div class="page-container">
            <!-- Page content -->
            <?php echo $body; ?>
            <!-- /page content -->
        </div>
        <?php
        $this->load->view('Templates/default_footer');
        ?>
        <!-- /page container -->
    </body>
</html>
