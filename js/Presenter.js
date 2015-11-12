var Presenter = {
    makeDocument: function(resource) {
        if (!Presenter.parser) {
            Presenter.parser = new DOMParser();
        }
        var doc = Presenter.parser.parseFromString(resource, "application/xml");
        return doc;
    },
    modalDialogPresenter: function(xml) {
        navigationDocument.presentModal(xml);
    },

    menuBarItemPresenter: function(xml, ele) {
        var feature = ele.parentNode.getFeature("MenuBarDocument");

        if (feature) {
        
            var currentDoc = feature.getDocument(ele);
        
            if (!currentDoc) {
                feature.setDocument(xml, ele);
            }
        }
    },

    defaultPresenter: function(xml) {
        console.log('default presenter');
    },
  

    load: function(event) {
        var self = this,
            ele = event.target,
            presentation = ele.getAttribute("presentation"),
            template = ele.getAttribute("template");

        console.log(presentation, template);
        self.showLoadingIndicator(presentation);

        if (presentation != "videoPresentation") {
            resourceLoader.loadResource(template, function(resource) {
                var doc = self.makeDocument(resource);
                doc.addEventListener('select', self.load.bind(self));


                if (self[presentation] instanceof Function) {
                    self[presentation].call(self, doc, ele);
                } else {
                    self.defaultPresenter.call(self, doc);
                }
            });
        } else if( presentation == 'videoPresentation' ) {

            videoURL = ele.getAttribute("videoURL")


            if(videoURL) {

                var player = new Player();
                var playlist = new Playlist();
                var mediaItem = new MediaItem("video", videoURL);

                player.playlist = playlist;
                player.playlist.push(mediaItem);
                player.present();
            }            
        }
  

    },

    showLoadingIndicator: function(presentation) {
        /*
        You can reuse documents that have previously been created. In this implementation
        we check to see if a loadingIndicator document has already been created. If it 
        hasn't then we create one.
        */
        if (!this.loadingIndicator) {
            this.loadingIndicator = this.makeDocument(this.loadingTemplate);
        }
        
        /* 
        Only show the indicator if one isn't already visible and we aren't presenting a modal.
        */
        if (!this.loadingIndicatorVisible && presentation != "modalDialogPresenter" && presentation != "menuBarItemPresenter") {
            navigationDocument.pushDocument(this.loadingIndicator);
            this.loadingIndicatorVisible = true;
        }
    },

     loadingTemplate: `<?xml version="1.0" encoding="UTF-8" ?>
        <document>
          <loadingTemplate>
            <activityIndicator>
              <text>Loading...</text>
            </activityIndicator>
          </loadingTemplate>
        </document>`
}