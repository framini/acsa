<?php if(isset($message)) { ?>
 <div class="ui-widget">
  <div class="<?php if(isset($estado) && $estado == "success") echo "ui-state-highlight"; else { ?>ui-state-error <?php } ?> ui-corner-all">
    <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
    <strong><?php echo $message; ?></strong></p>
  </div>
 </div>
<?php } ?> 