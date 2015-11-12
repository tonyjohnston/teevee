<?php echo 'var Template = function() { return `<?xml version="1.0" encoding="UTF-8" ?>
<document>
   <menuBarTemplate>
      <menuBar>
         <menuItem template="${this.BASEURL}xml/list.xml.js/?id=latest" presentation="menuBarItemPresenter"><title>Latest Episodes</title></menuItem>';
      if ( $content ) :
         for( $i = 0; $i < sizeof($content); $i++ ) : ?>
            <menuItem template="${this.BASEURL}xml/list.xml.js/?id=<?= $content[$i]->term_id ?>" presentation="menuBarItemPresenter"><title><?= apply_filters( 'the_title', $content[$i]->name ); ?></title></menuItem>
         <?php endfor;
      endif;
      echo '</menuBar>
   </menuBarTemplate>
</document>`;}'; ?>