
const app = new Vue({  
  data : {
    log : [],
    xml:null,
    csv : null
  },
  methods : {
    loadFile : function(evt)
    {
        var files = evt.target.files; // FileList object
        var file = files[0];
        var reader = new FileReader();
        var self = this;
        reader.onload = (function(theFile) {
          return function(e) {
              var parser = new DOMParser();    
            var xmlDoc = parser.parseFromString(e.target.result,"text/xml");
            console.log(xmlDoc);
            var xml = [];

            xml[0] = '0|DD-V1|' + xmlDoc.querySelector('CstmrDrctDbtInitn>PmtInf>ReqdColltnDt').textContent.replace(/-/g, '') + 
            '|70|' + xmlDoc.querySelector('CstmrDrctDbtInitn>PmtInf>NbOfTxs').textContent + '|' + 
            xmlDoc.querySelector('CstmrDrctDbtInitn>PmtInf>CtrlSum').textContent + '|1|EUR|'+ new Date().toISOString().replace(/-|T|:/g,'').split('.')[0];
            xml[1] = '1|'+ xmlDoc.querySelector('CstmrDrctDbtInitn>PmtInf>CtrlSum').textContent + '|' + 
            xmlDoc.querySelector('CstmrDrctDbtInitn>PmtInf>CdtrAcct>Id>IBAN').textContent+'|KC_Converter_'+ new Date().toDateString() +'|1000';
            self.xml = xml;
            var childs = xmlDoc.querySelectorAll('CstmrDrctDbtInitn>PmtInf>DrctDbtTxInf');
            for(var i=0;i<childs.length;i++)
            {
              xml.push('9|'+ childs[i].querySelector('InstdAmt').textContent + '|' +
              childs[i].querySelector('DbtrAcct>Id>IBAN').textContent +'|' + childs[i].querySelector('RmtInf>Ustrd').textContent +'|'+ (i+1));
              console.log(i);
            }
          
            self.csv = 'data:text/plain;charset=utf-8,' + encodeURIComponent(xml.join('\r\n'));
          };
        })(file);

        
        reader.readAsText(file);

    }
  },
  mounted : function()
  {
    console.log("heart beat");
    var self = this;
      
        

  }
}).$mount('#app')
