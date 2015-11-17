<?php echo 'var Template = function() { return `<?xml version="1.0" encoding="UTF-8" ?>
<document>
   <menuBarTemplate>
      <menuBar>
         <menuItem template="${this.BASEURL}xml/list.xml.js/?id=latest" presentation="menuBarItemPresenter"><title>Latest Episodes</title></menuItem>';
      if ( $content ) :

         foreach( $content as $series): ?>
            <menuItem template="${this.BASEURL}xml/list.xml.js/?id=<?= $series->term_id ?>" presentation="menuBarItemPresenter"><title><?= apply_filters( 'the_title', $series->name ); ?></title></menuItem>
         <?php endforeach;
      endif;
      echo '</menuBar>
   </menuBarTemplate>
</document>`;}'; ?>