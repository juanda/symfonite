
<?php
class myMenuOutput extends RecursiveIteratorIterator {
  function __construct($m) {
    parent::__construct($m, self::SELF_FIRST);
  }

  function beginChildren() {
    echo str_repeat("\t", $this->getDepth());
  }

  function endChildren() {
    echo str_repeat("\t", $this->getDepth() - 1);
  }
}

$root = sfBreadNavPeer::getRoot($scope);
$menu = sfBreadNavPeer::retrieveTree($scope);
$menu = new myMenuOutput($menu);



function bool2string ($bool) {
  if(!is_null($bool)) {return 'On';}
  return ' ';
}

?>

<br/>
    <table cellspacing="0">
      <tr class='odd'><th><?php echo __('Nombre del item') ?></th><th><?php echo __('Route') ?></th><th><?php echo __('Credencial') ?></th><th><?php echo __('Catch all') ?></th></strong></tr>
    
    <?php $rowclass = 'even'; ?>
    
    <?php $rootflag = true; ?>
    <?php foreach ($menu as $page): ?>
    <?php if (!$rootflag) { 
    ?>
    
    <tr class='<?php echo $rowclass ?>'>
      <td style='padding-left: <?php echo $page->getLevel() + 1?>EM; padding-right: 1EM;'>
      <?php echo link_to ($page->getPage(), '@sfBreadNav2Plugin_indexScopeId?scope=' .$scope. '&pageid=' . $page->getId()) ?>
      </td>
      <td><?php echo $page->getRoute()?></td>
      <td><?php echo $page->getCredential()?></td>
      <td><?php echo bool2string($page->getCatchall())?></td>            
    </tr>
    <?php if ($rowclass == 'odd') {$rowclass = 'even';} else {$rowclass = 'odd';} ?>
    
    <?php } else { $rootflag = false;}
    ?>        
    
    <?php endforeach; ?>
    </table>