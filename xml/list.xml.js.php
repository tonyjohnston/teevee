<?php 
echo 'var Template = function() { return `<?xml version="1.0" encoding="UTF-8" ?>
<document>

  <listTemplate class="mainList">
    <banner>
    <title>'.esc_html( $template_title ).'</title>
    </banner>
    <list>
      <section>';

        for( $i = 0; $i < count($content); $i++ ) :
            $e = $content[$i]; ?>
      
        <listItemLockup videoURL="<?= $e->video_uri ?>" presentation="videoPresentation">
          <title><?= apply_filters( 'the_title', $e->post_title ); ?></title>
          <relatedContent>
            <lockup >
              <?php if ( $e->cover_uri ): ?>
              <img src="<?= $e->cover_uri ?>" width="1400" height="1400" />
            <?php endif; ?>
              <title><?= apply_filters( 'the_title', $e->post_title ); ?></title>
              <subtitle><?= esc_html($e->subtitle) ?></subtitle>
              <description><?= esc_html($e->desc) ?></description>
            </lockup>
          </relatedContent>
        </listItemLockup>
      
    <?php endfor; ?>
    
<?php
echo '
      </section>
    </list>
  </listTemplate>
</document>`
}';
?>