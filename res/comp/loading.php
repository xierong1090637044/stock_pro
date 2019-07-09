<?php
     class loading
     {
         function __construct($id)
         {
             $this->id = $id;
         }

         public function loading()
         {
             echo <<< EOT
             <div id="$this->id">
             <div class="weui-mask_transparent"></div>
               <div class="weui-toast">
                 <i class="weui-loading weui-icon_toast"></i>
                 <p class="weui-toast__content">数据加载中</p>
               </div>
            </div>
EOT;
         }

         private $id;
     }
?>
