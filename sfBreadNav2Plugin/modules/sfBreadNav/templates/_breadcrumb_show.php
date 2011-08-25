<?php 

//get action and module
$c = new Criteria();
$c->add(sfBreadNavPeer::MODULE, $module);
$c->add(sfBreadNavPeer::ACTION, $action);
$c->add(sfBreadNavApplicationPeer::NAME, $menu);
$c->addJoin(sfBreadNavPeer::SCOPE, sfBreadNavApplicationPeer::ID);
$page = sfBreadNavPeer::doSelectOne($c);

if (!$page) {
  //page not found attempting to use catchall path  
  $c = new Criteria();
  $c->add(sfBreadNavPeer::MODULE, $module);
  $c->add(sfBreadNavPeer::CATCHALL, 0);
  $c->add(sfBreadNavApplicationPeer::NAME, $menu);
  $c->addJoin(sfBreadNavPeer::SCOPE, sfBreadNavApplicationPeer::ID);
  $page = sfBreadNavPeer::doSelectOne($c);  
}

if ($page) {$path = $page->getPath();
  $id = $page->getId();
  foreach ($path as $node) {
    if ($node->getId() != $id){
    	$pagename = is_callable("__") ? __($node->getPage()) : $node->getPage();
        echo link_to($pagename , $node->getModule() . '/' . $node->getAction()) . '&nbsp;&nbsp;>>&nbsp;&nbsp;';
      }
  }
}  

if ($page) {
	echo is_callable("__") ? __($page->getPage()) : $page->getPage();
} else { 
  $root = sfBreadNavPeer::getMenuRoot($menu);
  if ($root) {
  	$pagename = is_callable("__") ? __($root->getPage()) : $root->getPage();
    echo link_to($pagename, $root->getModule() . '/' . $root->getAction());
  } 
}

?>