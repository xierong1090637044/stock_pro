<?php
     /*** */
     class Append
     {

         function __construct($content)
         {
             $this->content = $content;
         }


         public function append()
         {
             echo <<< EOT
             $this->content
EOT;
         }
     }

?>
