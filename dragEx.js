class testDrag extends dragKwBaseClass {
    
    config() {
        this.charBase = 65;
        this.rowsn = 5;
        this.ordServerURL = '/t/22/06/drag/server.php';
        // this.setServerURL();
        this.theParentE = byid('thetbody');
    }
    
    constructor() {
       super();
       this.config();
       this.dragKwSetGrandParentE(this.theParentE);
       this.init10(); 
    }
    
    init10() {
        kwjss.sobf(this.ordServerURL, {'action' : 'init'}, (res) => { this.init20(res); } );
    }
    
    init20(ret) {
        
        this.dragSetMeta(this.ordServerURL, ret['meta']);
        // {'moreDatKeyEx' : 'moreDatValIgnoreMe'}
        this.dragSetMoreDat({'moreDatKeyEx' : 'moreDatValIgnoreMe'});
        
        for (let i = 0; i < this.rowsn; i++) {
            
            const r = ret['dat'][i];
            
            const idc = r['v'];
            const uqid = idc;
            
            const tr = cree('tr', r['_id']);
            this.setDragParent(tr, uqid, r['ordx']);
            const td10 = cree('td');
            td10.innerHTML = '&varr;';
            this.setEleDraggable(td10);
            tr.append(td10);
            
            const td20 = cree('td');
            td20.innerHTML = idc;
            tr.append(td20);
            
            this.theParentE.append(tr);
        }
    }
    
}

