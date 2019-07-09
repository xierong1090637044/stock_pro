<?php
     class Dialog
     {
         function __construct($id="dialog",$classname = null,$title="弹窗标题",$elements="自定义内容")
         {
             $this->id = $id;
             $this->classname = $classname;
             $this->title = $title;
             $this->elements = $elements;
         }

         public function dialog()
         {
             echo <<< EOT
             <div class="weui_dialog_confirm" style="display:none" id="$this->id">
                 <div class="weui_mask"></div>
                 <div class="weui_dialog $this->classname">
                     <div class="weui_dialog_hd"><strong class="weui_dialog_title">$this->title</strong></div>
                     <div class="weui_dialog_bd" style="text-align:center">$this->elements</div>
                     <div class="weui_dialog_ft">
                         <a href="javascript:;" class="weui_btn_dialog default" id="callce">取消</a>
                         <a href="javascript:;" class="weui_btn_dialog primary" id="confrim">确定</a>
                     </div>
                 </div>
             </div>
EOT;
         }

         private $classname;
         private $id;
         private $elements;
     }
?>
