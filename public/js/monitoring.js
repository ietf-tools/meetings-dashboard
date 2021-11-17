//window.setInterval("buildSystemsTable()", 5000);
//window.setInterval("updateSystemsTableUptime()", 5000);
window.setInterval("updateSystemsTablePing()", 5000);
window.setInterval("updateNetworkTransmit()", 5000);
window.setInterval("updateNetworkReceive()", 5000);
window.setInterval("updateDataTrackerLoginStatus()", 15000);
window.setInterval("updateOIDCLoginStatus()", 15000);
window.setInterval("updatePlatformHeath()", 100000);

function buildSystemsTable(){
  let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=node_exporter_build_info{instance=~"^me-.*$"}';
  siDiv = document.getElementById("serverInstancesCount");
  fetch(url)
    .then(function(response){
     return response.json();
    })
    .then(function(data) {
      //console.log(data.status);
      let dl = data.data.result.length;
      //console.log(dl);
      var i = 0;
      let table = document.getElementById("systemsTable").getElementsByTagName("tbody")[0];
      while (data.data.result[i]){
          let sn = data.data.result[i].metric.instance;
          let s = sn.split('.meeting')[0];
          let row = table.insertRow().outerHTML="<tr id='row"+sn+"'><td class='text-uppercase text-center' id='"+sn+"'><a href='https://graphs.noc.ietf.org/d/rYdddlPWk/server-details?orgId=1&var-DS_PROMETHEUS=Prometheus&var-job=node_exporter&var-node="+sn+"&refresh=1m+s+' style='color: #000000' target='_blank'>"+s+"</a></td><td id='icmp_"+sn+"' class='text-center CellWithComment' status='unknown'><span class='dot-unknown'></span></td><td id='cpu_"+sn+"' class='text-center CellWithComment' status='unknown'><span class='dot-unknown'></span></td><td id='mem_"+sn+"' class='text-center CellWithComment' status='unknown'><span class='dot-unknown'></span></td></tr>";

          //console.log(data.data.result[i].metric.instance);
          i ++;
      }
      siDiv.innerHTML=i;
    })
   .catch(function(error) {
      console.log(error);
      console.log(data);
    });
}
function updateSystemsTableUptime(){
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=time()-node_boot_time_seconds{instance=~"^me-.*$"}';
    fetch(url)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            //console.log(data);
            var i = 0;
            while (data.data.result[i]){
                let host = data.data.result[i].metric.instance;
                let seconds = data.data.result[i].value[1];
                let minutes = Math.floor(seconds / 60);
                let hours = Math.floor(seconds / 3600);
                console.log(hours);
                console.log(value);
                let upTimeCell = document.getElementById("uptime_"+host);
                upTimeCell.innerHTML = value;
                i++;
            }
        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
          });
}
function updateSystemsTableCpu(host){
    let cpuCell = document.getElementById("cpu_"+host);
    let cpuCellStatus = cpuCell.status;
    let cpuGood = 65.00;
    let cpuFail = 95.00;
    //onsole.log("Server: "+host+" Previous Status: "+cpuCellStatus);
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=(((count(count(node_cpu_seconds_total{instance="'+host+'",job="node_exporter"}) by (cpu))) - avg(sum by (mode)(irate(node_cpu_seconds_total{mode="idle",instance="'+host+'",job="node_exporter"}[5m])))) * 100) / count(count(node_cpu_seconds_total{instance="'+host+'",job="node_exporter"}) by (cpu))';
    fetch(url)
        .then(function(response){
        return response.json();
        })
        .then(function(data) {
            //console.log(data);
            let cpuPercentage = parseFloat(data.data.result[0].value[1]);
            let cpuPercent = cpuPercentage.toFixed(2);
            let cpuCellComment = document.getElementById("mem_"+host+"_cell_comment");
            let cpuStatus;
            let cpuHTML;
            //console.log(cpuPercent);
            if(cpuPercent < cpuGood){
                if(cpuCellStatus != "Good"){
                    cpuStatus = "Good";
                    cpuHTML = '<span class="bullet bg-success h-15px w-25px me-5"></span><span id="cpu_'+host+'_cell_comment" class="text-left CellComment"><b>CPU Used: </b>'+cpuPercent+'%</span>';
                    cpuCell.innerHTML = cpuHTML;
                    cpuCell.status = cpuStatus;
                }else{
                    cpuCellCommentContent = "<b>CPU Used: </b>"+cpuPercent+"%";
                    cpuCellComment.innerHTML = cpuCellCommentContent;
                }
            }
            if(cpuPercent >= cpuGood && cpuPercent < cpuFail){
                if(cpuCellStatus != "Warn"){
                    cpuStatus = "Warn";
                    cpuHTML = '<span class="bullet bg-warning h-15px w-25px me-5"></span><span id="cpu_'+host+'_cell_comment" class="text-left CellComment"><b>CPU Used: </b>'+cpuPercent+'%</span>';
                    cpuCell.innerHTML = cpuHTML;
                    cpuCell.status = cpuStatus;
                }else{
                    cpuCellCommentContent = "<b>CPU Used: </b>"+cpuPercent+"%";
                    cpuCellComment.innerHTML = cpuCellCommentContent;
                }
            }
            if(cpuPercent >= cpuFail){
                if(cpuCellStatus != "Fail"){
                    cpuStatus = "Fail";
                    cpuHTML = '<span class="bullet bg-danger h-15px w-25px me-5"></span><span id="cpu_'+host+'_cell_comment" class="text-left CellComment"><b>CPU Used: </b>'+cpuPercent+'%</span>';
                    cpuCell.innerHTML = cpuHTML;
                    cpuCell.status = cpuStatus;
                }else{
                    cpuCellCommentContent = "<b>CPU Used: </b>"+cpuPercent+"%";
                    cpuCellComment.innerHTML = cpuCellCommentContent;
                }
            }
            //console.log(host+" CPU Status is: "+cpuStatus+" CPU Percentage: "+cpuPercent+"%");

        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
        });
}
function updateSystemsTableMem(host){
    let memCell = document.getElementById("mem_"+host);
    let memCellStatus = memCell.status;
    let memCellComment = document.getElementById("mem_"+host+"_cell_comment");
    let memGood = 50.00;
    let memFail = 75.00;
    //onsole.log("Server: "+host+" Previous Status: "+memCellStatus);
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=100-((node_memory_MemAvailable_bytes{instance="'+host+'",job="node_exporter"} * 100) / node_memory_MemTotal_bytes{instance="'+host+'",job="node_exporter"})';
    fetch(url)
        .then(function(response){
        return response.json();
        })
        .then(function(data) {
            //console.log(data);
            let memPercentage = parseFloat(data.data.result[0].value[1]);
            let memPercent = memPercentage.toFixed(2);
            let memStatus;
            let memHTML;
            //console.log(cpuPercent);
            if(memPercent < memGood){
                if(memCellStatus != "Good"){
                    memStatus = "Good";
                    memHTML = '<span class="bullet bg-success h-15px w-25px me-5"></span><span id="mem_'+host+'_cell_comment" class="text-left CellComment"><b>Memory Used: </b>'+memPercent+'%</span>';
                    memCell.innerHTML = memHTML;
                    memCell.status = memStatus;
                }else{
                    memCellCommentContent = "<b>Memory Used: </b>"+memPercent+"%";
                    memCellComment.innerHTML = memCellCommentContent;
                }
            }
            if(memPercent >= memGood && memPercent < memFail){
                if(memCellStatus != "Warn"){
                    memStatus = "Warn";
                    memHTML = '<span class="bullet bg-warning h-15px w-25px me-5"></span><span id="mem_'+host+'_cell_comment" class="text-left CellComment"><b>Memory Used: </b>'+memPercent+'%</span>';
                    memCell.innerHTML = memHTML;
                    memCell.status = memStatus;
                }else{
                    memCellCommentContent = "<b>Memory Used: </b>"+memPercent+"%";
                    memCellComment.innerHTML = memCellCommentContent;
                }
            }
            if(memPercent >= memFail){
                if(memCellStatus != "Fail"){
                    memStatus = "Fail";
                    memHTML = '<span class="bullet bg-danger h-15px w-25px me-5"></span><span id="mem_'+host+'_cell_comment" class="text-left CellComment"><b>Memory Used: </b>'+memPercent+'%</span>';
                    memCell.innerHTML = memHTML;
                    memCell.status = memStatus;
                }else{
                    memCellCommentContent = "<b>Memory Used: </b>"+memPercent+"%";
                    memCellComment.innerHTML = memCellCommentContent;
                }
            }
            //console.log(host+" CPU Status is: "+cpuStatus+" CPU Percentage: "+cpuPercent+"%");

        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
        });
}
function updateSystemsTableDisk(){
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=time()-node_boot_time_seconds{instance=~"^me-.*$"}';
    fetch(url)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            //console.log(data);
            var i = 0;
            while (data.data.result[i]){
                let host = data.data.result[i].metric.instance;
                //console.log(host);
                let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=up{instance="'+host+'",job=~"^blackbox.*$"}';
                fetch(url)
                    .then(function(response){
                    return response.json();
                    })
                    .then(function(data) {
                        //console.log(data);
                        var p = 0;
                        let numberOfValues = data.data.result.length;
                        let statusOfValues = 0;
                        let status;
                        let pingCell = document.getElementById("icmp_"+host);
                        while (data.data.result[p]){
                            if(data.data.result[p].value[1] == 1){
                                statusOfValues++;
                            }
                            p++;
                        }
                        if(statusOfValues == numberOfValues){
                            pingCell.innerHTML = "<span class='dot-good'></span>"
                            status = "UP";
                        }
                        if(statusOfValues < numberOfValues){
                            pingCell.innerHTML = "<span class='dot-warn'></span>"
                            status = "Warn";
                        }
                        if(statusOfValues == 0){
                            pingCell.innerHTML = "<span class='dot-fail'></span>"
                            status = "Down";
                        }
                        //console.log(host+" : Number of Values: "+ numberOfValues + " Status of Values: " + statusOfValues + " System Status: " + status);
                    })
                    .catch(function(error) {
                        console.log(error);
                        console.log(data);
                    });
                i++;
            }
        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
        });
}
function updateSystemsRTT(host){
    let urlICMPRTT = 'https://prometheus.noc.ietf.org/api/v1/query?query=probe_icmp_duration_seconds{instance="'+host+'",phase="rtt"}';
    let pingCellComment = document.getElementById("icmp_"+host+"_cell_comment");
    fetch(urlICMPRTT)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            //console.log(data);
            let r = 0;
            let asia;
            let japan;
            let europe;
            let dfw;
            while (data.data.result[r]){
                let loc = data.data.result[r].metric.job;
                let rtt = parseFloat(data.data.result[r].value[1]);
                rttFixed = rtt.toFixed(3);
                rttMS = rttFixed * 1000;
                if(loc == "blackbox_icmp_remote_asia"){
                    asia = rttMS;
                }else if(loc == "blackbox_icmp_remote_japan"){
                    japan = rttMS;
                }else if( loc == "blackbox_icmp_remote_europe"){
                    europe = rttMS;
                }else if( loc == "blackbox_icmp"){
                    dfw = rttMS;
                }
                r++;
            }
            let pingCellCommentContent = "<b>USA RTT: </b>"+dfw+"ms<br><b>SE Asia RTT: </b>"+asia+"ms<br><b>Europe RTT: </b>"+europe+"ms<br><b>Japan RTT: </b>"+japan+"ms";
            pingCellComment.innerHTML = pingCellCommentContent;
        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
        });
}
function updateSystemsTablePing(){
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=time()-node_boot_time_seconds{instance=~"^me-.*$"}';
    fetch(url)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            //console.log(data);
            var i = 0;
            while (data.data.result[i]){
                let host = data.data.result[i].metric.instance;
                let pingCell = document.getElementById("icmp_"+host);
                let pingCellStatus = pingCell.status;
                //console.log(host);
                let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=up{instance="'+host+'",job=~"^blackbox.*$"}';
                fetch(url)
                    .then(function(response){
                    return response.json();
                    })
                    .then(function(data) {
                        //console.log(data);
                        var p = 0;
                        let numberOfValues = data.data.result.length;
                        let statusOfValues = 0;
                        let status;
                        while (data.data.result[p]){
                            if(data.data.result[p].value[1] == 1){
                                statusOfValues++;
                            }
                            p++;
                        }
                        if(statusOfValues == numberOfValues){
                            //console.log(pingCellStatus);
                            if(pingCellStatus != "Good"){
                                pingCell.innerHTML = '<span class="bullet bg-success h-15px w-25px me-5"></span><span id="icmp_'+host+'_cell_comment" class="text-left CellComment"></span>';
                                status = "Good";
                                pingCellStatus = status;
                                updateSystemsTableCpu(host);
                                updateSystemsTableMem(host);
                                updateSystemsRTT(host);
                            }else{
                                updateSystemsTableCpu(host);
                                updateSystemsTableMem(host);
                                updateSystemsRTT(host);
                            }
                        }
                        if(statusOfValues < numberOfValues){
                            if(pingCellStatus != "Warn"){
                                pingCell.innerHTML = '<span class="bullet bg-warning h-15px w-25px me-5"></span><span id="icmp_'+host+'_cell_comment" class="text-left CellComment"></span>';
                                status = "Warn";
                                pingCellStatus = status;
                                updateSystemsTableCpu(host);
                                updateSystemsTableMem(host);
                                updateSystemsRTT(host);
                            }else{
                                updateSystemsTableCpu(host);
                                updateSystemsTableMem(host);
                                updateSystemsRTT(host);
                            }
                        }
                        if(statusOfValues == 0){
                            if(pingCellStatus != "Fail"){
                                pingCell.innerHTML = '<span class="bullet bg-danger h-15px w-25px me-5"></span><span id="icmp_'+host+'_cell_comment" class="text-left CellComment"></span>';
                                status = "Fail";
                                pingCellStatus = status;
                                updateSystemsTableCpu(host);
                                updateSystemsTableMem(host);
                                updateSystemsRTT(host);
                            }else{
                                updateSystemsTableCpu(host);
                                updateSystemsTableMem(host);
                                updateSystemsRTT(host);
                            }
                        }
                        //console.log(host+" : Number of Values: "+ numberOfValues + " Status of Values: " + statusOfValues + " System Status: " + status);
                    })
                    .catch(function(error) {
                        console.log(error);
                        console.log(data);
                    });
                i++;
            }
        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
        });
}
function updateNetworkTransmit(){
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=sum(irate(node_network_transmit_bytes_total{device="ens5",job="node_exporter"}[5m])*8)';
    fetch(url)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            //console.log(data);
            let intSpeedBps = data.data.result[0].value[1];
            let bps = intSpeedBps * 8;
            let mbps = bps / 10000000;
            document.getElementById("transmitTrafficTile").innerHTML = '<p class="text-center">'+mbps.toFixed(1) + ' Mbps</p>';
        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
        });

}
function updateNetworkReceive(){
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=sum(irate(node_network_receive_bytes_total{device="ens5",job="node_exporter"}[5m])*8)';
    fetch(url)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            //console.log(data);
            let intSpeedBps = data.data.result[0].value[1];
            let bps = intSpeedBps * 8;
            let mbps = bps / 10000000;
            document.getElementById("receiveTrafficTile").innerHTML = '<p class="text-center">'+mbps.toFixed(1) + ' Mbps</p>';
        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
        });

}
function updateDataTrackerLoginStatus(){
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=datatracker_status!=1';
    dtStatusDiv = document.getElementById("dtStatus");
    fetch(url)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            if(data.data.result.length == 0){
                //console.log('All DataTracker Processes functioning');
                dtStatusDiv.innerHTML = '<p class="text-center">Good</p>';
            }else{
                dtStatusDiv.innerHTML = '<p class="text-center">Trouble</p>';
            }
        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
        });
}
function updateOIDCLoginStatus(){
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=oidc_status!=1';
    oidcStatusDiv = document.getElementById("oidcStatus");
    fetch(url)
        .then(function(response){
            return response.json();
        })
        .then(function(data){
            if(data.data.result.length == 0){
                //console.log('All OIDC Processes functioning');
                oidcStatusDiv.innerHTML = '<p class="text-center">Good</p>';
            }else{
                oidcStatusDiv.innerHTML = '<p class="text-center">Trouble</p>';
            }
        })
        .catch(function(error) {
            console.log(error);
            console.log(data);
        });
}
async function updatePlatformHeath(){
    phDiv = document.getElementById("platformHealth");
    let checks = 0;
    let checksPassed = 0;
    // Check ICMP Health Status
    let icmpHealth = await checkICMPHealth();
    checks = checks + icmpHealth.c;
    checksPassed = checksPassed + icmpHealth.cp;

    // Check Node Health Status
    let nodeHealth = await checkNodeHealth();
    checks = checks + nodeHealth.c;
    checksPassed = checksPassed + nodeHealth.cp;

    //Do some Math
    phPercent = checksPassed / checks * 100;
    console.log(phPercent);
    phDiv.innerHTML = '<p class="text-center">'+phPercent+'%</p>';
    console.log("Checks Run: "+checks+" Checks Passed: "+checksPassed);

}
async function checkICMPHealth(){
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=up{job=~"^blackbox_icmp.*$",instance=~"^me-.*$"}';
    var i = 0;
    var c = 0;
    var cp = 0;
    const response = await fetch(url);
    const icmpCheck = await response.json();
    //console.log(icmpCheck);
    while(icmpCheck.data.result[i]){
        c++;
        if(icmpCheck.data.result[i].value[1] == 1){
            cp++;
        }
        i++;
    }
    return {c, cp};
}
async function checkNodeHealth(){
    let url = 'https://prometheus.noc.ietf.org/api/v1/query?query=up{job="node_exporter",instance=~"^me-.*$"}';
    var i = 0;
    var c = 0;
    var cp = 0;
    const response = await fetch(url);
    const nodeCheck = await response.json();
    //console.log(icmpCheck);
    while(nodeCheck.data.result[i]){
        c++;
        if(nodeCheck.data.result[i].value[1] == 1){
            cp++;
        }
        i++;
    }
    return {c, cp};
}

//updatePlatformHeath();
buildSystemsTable();
updateOIDCLoginStatus();
updateDataTrackerLoginStatus();
updateNetworkTransmit();
updateNetworkReceive();

