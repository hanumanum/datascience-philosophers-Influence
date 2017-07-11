    //var s = new sigma('graph-container');
    var s = new sigma({
                      renderers: [
                        {
                          container: document.getElementById('graph-container'),
                          type: 'canvas' // sigma.renderers.canvas works as well
                        }
                      ],
                      minArrowSize: 10,
                    });    



    s.bind("clickNode", function (e) {
        highlight(e.data.node);        
        s.refresh();
    });

    function highlight(nodeSelected){
        s.graph.edges().forEach(function(ed){
            if(ed.source !== nodeSelected.id){
                ed.color=opac.set(ed.color).down();
            }
            else{
                ed.color=opac.set(ed.color).up();
            }
        });
    }
   

    var x = 0;
    var y = 0;
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var names = JSON.parse(this.response);
        names.forEach(function(p){
                 
        s.graph.addNode({
            id: p.name,
            label: p.name +"("+ p.birthyear+")",
            x: convertToLog(p.birthyear),
            y: -p.infForce*50,
            //y: (p.infForce>5)?rnd(0,100):rnd(600,1200),
            size: Math.sqrt(p.infForce+10),
            color: rnd.RGBA()           
          });
       
        })

        makeEdges();

        s.refresh();
      }
    };
    xmlhttp.open("GET", "database.php?info=names" , true);
    xmlhttp.send();



    function makeEdges(){

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var pairs = JSON.parse(this.response);
            pairs.forEach(function(e){
              
            s.graph.addEdge({
                id: e.id,
                source: e.source,
                target: e.target,
                color: s.graph.nodes(e.source).color,
                "type": "arrow",
              })
          })


            s.refresh();
            console.log(s.graph.edges());
          }
        };
        xmlhttp.open("GET", "database.php?info=pairs" , true);
        xmlhttp.send();
        //console.log(s.graph.nodes("Immanuel Kant"));
        
        
    }

    var rnd= {
        rndNumb: function(min,max){
            return Math.floor(Math.random()*(max-min+1)+min);
        },
        HEX: function(){
            return '#'+Math.floor(Math.random()*16777215).toString(16)
        },
        RGBA: function(){
            return "rgba("+this.rndNumb(0,255)
                          +(",")
                          +this.rndNumb(0,255)
                          +","
                          +this.rndNumb(0,255)
                          +",1)";
        }
    }

   
   var opac = {
    rgbarray:[],
    set:function(rgbastr){
        var regExp = /\(([^)]+)\)/;
        var matches = regExp.exec(rgbastr);
        this.rgbarray=matches[1].split(",");
        return this;
    },
    down:function(){
        return "rgba(" 
                + this.rgbarray[0]
                + ","
                + this.rgbarray[1]
                + ","
                + this.rgbarray[2] 
                + ",0)";
    },
    up:function(){
        return "rgba(" 
                + this.rgbarray[0] 
                + ","
                + this.rgbarray[1] 
                + ","
                + this.rgbarray[2] 
                + ",1)";
    },
   } 

   function convertToLog(position) {
        var minp = -1000;
        var maxp = 2000;
        var minv = Math.log(5);
        var maxv = Math.log(4000);
        var scale = (maxv-minv) / (maxp-minp);
        return Math.exp(minv + scale*(position-minp));
      }