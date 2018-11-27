    </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/jquery.minicolors.min.js"></script>
    <script type="text/javascript">
        $(function(){
          var colpick = $('.demo').each( function() {
            $(this).minicolors({
              control: $(this).attr('data-control') || 'hue',
              inline: $(this).attr('data-inline') === 'true',
              letterCase: 'lowercase',
              opacity: false,
              change: function(hex, opacity) {
                if(!hex) return;
                if(opacity) hex += ', ' + opacity;
                try {
                  console.log(hex);
                } catch(e) {}
                $(this).select();
              },
              theme: 'bootstrap'
            });
          });

          var $inlinehex = $('#inlinecolorhex h3 small');
          $('#inlinecolors').minicolors({
            inline: true,
            theme: 'bootstrap',
            change: function(hex) {
              if(!hex) return;
              $inlinehex.html(hex);
            }
          });
        });
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
          })
    </script>
  </body>

</html>

<?php
    
    /********************
    Close database connection
    ********************/
    $conn->close();
?>