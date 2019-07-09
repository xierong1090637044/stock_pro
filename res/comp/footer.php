<?php
     class footer
     {
         function __construct($classname=null)
         {
             $this->classname = $classname;
         }

         public function footer()
         {
             echo <<< EOT
             <div class="weui-footer $this->classname" style="text-align: center;width: 100%;font-size:12px">
              <p class="weui-footer__text">Copyright &copy; 20016-2018 繁花相送</p>
             </div>
EOT;
         }

         private $classname;
     }
?>
