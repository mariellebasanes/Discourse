$('.poll-container').hide();
                    var updated_data=[];
                    updated_data=res.data_values;
                    var my_data=updated_data;
                    document.getElementById('question').innerHTML=res.poll_question;
                    document.getElementById("chartBox").style.height = "80%";
                    //AJAX call for updating values
                    
                    
                    
                    if(my_data.length==0){
                      document.getElementById('no_data').innerHTML="No responses yet.";
                   
                    }
                    setInterval(function() {
                                    $.ajax({
                                  type:"POST",
                                  url: "ajax/view-analytics.php",
                                  datatype:'json',
                                                  
                                  data: {
                                      'event_id': event_id,
                                      'poll_code': poll_code,
                                                      
                                    },
                                  success: function(db_call) {
                                    var res2 = jQuery.parseJSON(db_call);
                                    updated_data=res2.data_values;
                                    
                                  }
                                });
                              if(my_data.length==0){
                                
                                location.reload();
                              }
                               
                             
                            }, 5000);   
                           
                            const words = res.data_values;
                            document.getElementById('question').innerHTML=res.poll_question;
                            const config = {
                              type: "wordCloud",
                              data: {
                                labels: words.map((d) => d.key),
                                
                                datasets: [
                                  {
                                   
                                    label: "Score",
                                    data: words.map((d) =>  d.value )
                                  }
                                ]
                              },
                              
                              options: {
                               
                               family: "Tahoma",
                               minRotation: 0,
                               maxRotation: 0,
                               
                               hoverColor:[
                                  '#ff1a68',
                                  '#36a2eb',
                                  '#ffce56',
                                  '#4bc0c0',
                                  '#9966ff',
                                  '#ff9f40',
                                  '#21b849',
                                  '#FF5733',
                                  '#FFBD33',
                                  '#33FF57',
                                  '#DBFF33',
                                  '#75FF33',
                                  '#08C3CD',
                                  '#CD08C3',
                               ],
                                color:[
                                  '#ff1a68',
                                  '#36a2eb',
                                  '#ffce56',
                                  '#4bc0c0',
                                  '#9966ff',
                                  '#ff9f40',
                                  '#21b849',
                                  '#FF5733',
                                  '#FFBD33',
                                  '#33FF57',
                                  '#DBFF33',
                                  '#75FF33',
                                  '#08C3CD',
                                  '#CD08C3',
                                  ],
                                
                                
                                  
                                minAngle: 0,
                                title: {
                                  display: false,
                                  text: "Word Cloud Poll"
                                },
                                plugins: {
                                 
                                  legend: {
                                    display: false
                                  }
                                }
                              }
                            }
                            let chartStatus = Chart.getChart("myChart"); // <canvas> id
                            if (chartStatus != undefined) {
                              chartStatus.destroy();
                            }
                        //-- End of chart destroy   
                            var chartCanvas = $('#myChart'); //<canvas> id
                            chartInstance = new Chart(chartCanvas, config);
                            // render init block
                     
                            // UPDATES THE DATA TO THE CHART
                            setInterval(function() {
                              chartInstance.data.labels = updated_data.map((d) => d.key);
                              chartInstance.data.datasets[0].data = updated_data.map((d) =>  d.value );
                              chartInstance.update();
                              //.log(updated_data);
                            },5000);
                         