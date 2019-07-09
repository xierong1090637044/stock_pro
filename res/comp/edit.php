<?php
     require_once "page.php";

     class Edit
     {
         function __construct()
         {

         }

         public function edit()
         {
             $html = "<div></div>";

             $this->page = new Append($html);
             $this->page->append();
         }

         private $classname;
         private $id;
         private $elements;
     }
?>
