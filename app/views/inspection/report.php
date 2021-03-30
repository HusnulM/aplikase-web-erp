    <section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>

                            <ul class="header-dropdown m-r--5">          
                                <a href="<?= BASEURL; ?>/inspection" class="btn bg-green waves-effect">
                                    <i class="material-icons">skip_previous</i> <span>BACK</span>
                                </a>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-3">
                                    <label for="fromdate">Tanggal</label>
                                    <input type="date" name="fromdate" id="fromdate" class="form-control"  required/>
                                </div>
                                <div class="col-lg-3">
                                    <label for="fromdate">-</label>
                                    <input type="date" name="todate" id="todate" class="form-control"  required/>
                                </div>
                                <div class="col-lg-2">
                                    <br>
                                    <button class="btn bg-green waves-effect" id="btn-display">
                                        <i class="material-icons">search</i> <span>Tampilkan Data</span>
                                    </button>
                                </div>
                                <div class="col-lg-2">
                                    <br>
                                    <button class="btn bg-green waves-effect" id="btn-export">
                                    <i class="material-icons">file_download</i> <span>Export Data</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-lg-5">
                                    <table class="table">
                                        <thead>
                                            <th>No</th>
                                            <th>Jenis Defect</th>
                                            <th>Jumlah NG</th>
                                        </thead>
                                        <tbody id="tbl-data">
                                        
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-7">
                                    <canvas id="bar_chart" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>

    <script>

        var chartlabel = [];
        var chartdata  = [];
        var myChart;
        var strval = '';
        $(function () {
            $('#report-content').hide();
            $('#btn-display').on('click', function(){
                readData();                
            });

            $('#btn-export').on('click', function(){
                let strdate = $('#fromdate').val();
                let enddate = $('#todate').val();      
                // window.open(base_url+"/inspection/exportdata/"+strdate+"/"+enddate, '_blank');
                window.open(base_url+"/inspection/testchart/"+strdate+"/"+enddate, '_blank');
            });
        });

        function readData(){
            let strdate = $('#fromdate').val();
            let enddate = $('#todate').val();            

            chartlabel = [];
            chartdata  = [];
            $('#tbl-data').html('');
            $.ajax({
                url: base_url+'/inspection/reportDefect/'+strdate+'/'+enddate,
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(result){                                        

                    // var ctx = document.getElementById('bar_chart').getContext('2d');
                    
                    // if (myChart) {
                    //     myChart.destroy();
                    // }
                    // myChart = new Chart(ctx, {
                    //     type: 'radar',
                    //     data: {
                    //         labels: chartlabel,
                    //         datasets: [{
                    //             label: 'Defect',
                    //             backgroundColor: 'rgba(0, 188, 212, 0.8)',
                    //             data: chartdata
                    //         }]
                    //     },
                    //     options: {
                    //         responsive: false,
                    //         legend: true,
                    //         scales: {
                    //             yAxes: [{
                    //                 ticks: {
                    //                     beginAtZero: true
                    //                 }
                    //             }]
                    //         }
                    //     }
                    // });
                }
            }).done(function(result){
                let count = 0;
                    
                for(var i = 0; i < result.length; i++){
                    count = count + 1;
                    $('#tbl-data').append(`
                        <tr>
                            <td>`+ count +`</td>
                            <td>`+ result[i].defect +`</td>
                            <td>`+ result[i].jmlng +`</td>
                        </tr>
                    `);
                    chartlabel.push(result[i].defect);
                    chartdata.push(result[i].jmlng);
                }

                if (myChart) {
                    myChart.destroy();
                }
                myChart = new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('bar'));   
            });  
        }

        function getChartJs(type) {
            var config = null;

            if (type === 'line') {
                config = {
                    type: 'line',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [
                            {
                                label: "My First dataset",
                                data: [65, 59, 80, 81, 56, 55, 40],
                                borderColor: 'rgba(0, 188, 212, 0.75)',
                                backgroundColor: 'rgba(0, 188, 212, 0.3)',
                                pointBorderColor: 'rgba(0, 188, 212, 0)',
                                pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                                pointBorderWidth: 1
                            }, 
                            {
                                label: "My Second dataset",
                                data: [28, 48, 40, 19, 86, 27, 90],
                                borderColor: 'rgba(233, 30, 99, 0.75)',
                                backgroundColor: 'rgba(233, 30, 99, 0.3)',
                                pointBorderColor: 'rgba(233, 30, 99, 0)',
                                pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                                pointBorderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            else if (type === 'bar') {
                // config = {
                //     type: 'bar',
                //     data: {
                //         labels: chartlabel,
                //         datasets: [{
                //                 label: "Defect",
                //                 data: chartdata,
                //                 backgroundColor: 'rgba(233, 30, 99, 0.8)'
                //             }]
                //     },
                //     options: {
                //         responsive: true,
                //         legend: false,
                //         scales: {
                //                 yAxes: [{
                //                     ticks: {
                //                         beginAtZero: true
                //                     }
                //                 }]
                //             }
                //     }
                // }
                config = {
                    type: 'bar',
                    data: {
                        labels: chartlabel,
                        datasets: [
                            {
                                label: "Defect",
                                data: chartdata,
                                backgroundColor: 'rgba(0, 188, 212, 0.8)'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                }
            }
            else if (type === 'radar') {
                config = {
                    type: 'radar',
                    data: {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [{
                            label: "My First dataset",
                            data: [65, 25, 90, 81, 56, 55, 40],
                            borderColor: 'rgba(0, 188, 212, 0.8)',
                            backgroundColor: 'rgba(0, 188, 212, 0.5)',
                            pointBorderColor: 'rgba(0, 188, 212, 0)',
                            pointBackgroundColor: 'rgba(0, 188, 212, 0.8)',
                            pointBorderWidth: 1
                        }, {
                                label: "My Second dataset",
                                data: [72, 48, 40, 19, 96, 27, 100],
                                borderColor: 'rgba(233, 30, 99, 0.8)',
                                backgroundColor: 'rgba(233, 30, 99, 0.5)',
                                pointBorderColor: 'rgba(233, 30, 99, 0)',
                                pointBackgroundColor: 'rgba(233, 30, 99, 0.8)',
                                pointBorderWidth: 1
                            }]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            else if (type === 'pie') {
                config = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [225, 50, 100, 40],
                            backgroundColor: [
                                "rgb(233, 30, 99)",
                                "rgb(255, 193, 7)",
                                "rgb(0, 188, 212)",
                                "rgb(139, 195, 74)"
                            ],
                        }],
                        labels: [
                            "Pink",
                            "Amber",
                            "Cyan",
                            "Light Green"
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: false
                    }
                }
            }
            return config;
        }
    </script>