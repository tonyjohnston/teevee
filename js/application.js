// 1
var resourceLoader;

var createAlert = function(title, description) {  

    var alertString = `<?xml version="1.0" encoding="UTF-8" ?>
        <document>
          <alertTemplate>
            <title>${title}</title>
            <description>${description}</description>
          </alertTemplate>
        </document>`

    var parser = new DOMParser();

    var alertDoc = parser.parseFromString(alertString, "application/xml");

    return alertDoc
}

 
App.onLaunch = function(options) {
  // 2
  var javascriptFiles = [
    `${options.PLUGINURL}js/ResourceLoader.js`, 
    `${options.PLUGINURL}js/Presenter.js`
  ];

  evaluateScripts(javascriptFiles, function(success) {
    if(success) {
      
      resourceLoader = new ResourceLoader(options.BASEURL);
      resourceLoader.loadResource(`${options.BASEURL}xml/index.xml.js/`, 
        function(resource) {
          var doc = Presenter.makeDocument(resource);
          doc.addEventListener("select", Presenter.load.bind(Presenter));
          navigationDocument.pushDocument(doc);
      });
    } else {
      var errorDoc = createAlert("Evaluate Scripts Error", "Error attempting to evaluate external JavaScript files.");
      navigationDocument.presentModal(errorDoc);
    }
  });
}
 
// Leave createAlert alone
