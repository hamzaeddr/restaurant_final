
        $(document).ready(function() {

          var tableData = []; 
          var tableData2 = []; 

          var tableData3 = []; 
          var tableData4 = []; 
          var tableData5 = []; 

         var tableData7 = [];
        
/////////////////repartition id //////////////////////////////

$('body').on('click', '.tabrow2 tr',function () {

     tableData2 = $(this).children("td").map(function () {
          return $(this).text();
        }).get();

});
/////////////////commande id //////////////////////////////

$('body').on('click', '.tabrowC tr',function () {

     tableData7 = $(this).children("td").map(function () {
          return $(this).text();
        }).get();
       
        $('.tabrowC tr').css('background-color', 'white');
        $(this).css('background-color', '#cacaca');
});

/////////////////produit id //////////////////////////////

$('body').on('click', '.tbody2 tr',function () {

     tableData3 = $(this).children("td").map(function () {
          return $(this).text();
        }).get();
        $('.tbody2 tr').css('background-color', 'white');
        $(this).css('background-color', '#cacaca');

});

 ////////////////sidebarclick////////////////////////////////

            $('.sidebarBtn').on('click',function () { 
                if($( ".sidebar" ).hasClass("active")){
                    $( ".sidebar" ).removeClass("active")
                }
                else{
                    $( ".sidebar" ).addClass("active")
                }
            });

          $('#myModal').on('shown.bs.modal', function () {
             $('#myInput').trigger('focus')
          })


  
////////////////////////////////////////////////////////////

    $('.check-date').on('change',function () {
                $('.check-date').attr('checked', false);
                $(this).attr('checked', true);
                let selectedProject = $(this).attr("data-id");
             
                 $.ajax({
                     type: "POST",
                     url:'/filtretablecarte/'+selectedProject,
                     success:function(data) {
                         $('.tbodycarte').html(data); 
                         console.log(data);
                      }
                 })
            });
    
          $('body').on('click','.tabrow tr',function () {
                $('.tabrow tr').css('background-color', 'white');
                $(this).css('background-color', '#cacaca');

                 let selectedProject = $(this).find("td:eq(1)").attr("data-id");
                  
                    tableData = $(this).children("td").map(function () {
                         return $(this).text();
                       }).get();
                       
                       if(tableData[6] == "B2C") {
                            $("#b2c").removeClass('show');
                            $("#b2c").removeClass('hide');
                            $("#b2c").addClass('show');

                       }
                       else{
                         $("#b2c").removeClass('show');
                         $("#b2c").removeClass('hide');
                         $("#b2c").addClass('hide');

                       }

                    $.ajax({
                         type: "POST",
                         url:'/remplirtablerepar/'+selectedProject,
                         success:function(data) {
                              $('.tbody').html(data);
                              console.log(data)
                         }
                    })
            });

            $('body').on('click', '.tabrow2 tr',function () {
               $('.tabrow2 tr').css('background-color', 'white');
               $(this).css('background-color', '#cacaca');

               let selectedProject = $(this).find("td:eq(1)").text();
                $.ajax({
                    type: "POST",
                    url:'/remplirtablepro/'+tableData2[0],
                    
                    success:function(data) {
                         $('.tbody2').html(data);
                        console.log(data)
                     }
                })
           });


            $('.navIMG ').on('click',function () {
                $('.navIMG').css('background-color', 'white');
                $(this).css('background-color', '#cacaca');

                 let selectedProject = $(this).find("a").attr("data-id");
               
                 $.ajax({
                     type: "POST",
                     url:'/remplirtableSousFamille/'+selectedProject,
                     
                     success:function(data) {
                          $('.tbodySousFamille').empty().html(data);
                         console.log(data)
                      }
                 })
            });


             $('body').on('click','.navImgProduit42',function () {
                $('.navImgProduit4').css('background-color', 'white');
               //  $(this).css('background-color', '#cacaca');

                 let selectedProject = $(this).find("a").attr("data-id");
                 $.ajax({
                     type: "POST",
                     url:'/remplirtableProduit/'+selectedProject,
                     
                     success:function(data) { 
                          $('.tbodyProduit').html(data);
                         console.log(data)
                      }
                 })
            });

  

             $('body').on('click','.NavAjtPro ',function () {
            
                 let selectedProject = $(this).find("a").attr("data-id");
               
                 $.ajax({
                     type: "POST",
                     url:'/remplirNavSousFamille/'+selectedProject,
                     
                     success:function(data) {
                        
                          $('.navSF').empty().append(data);
                              console.log(data)
                      }
                 })
            });
   
             $('.slct').on('change',function () {
                 let selectedProject = $(this).val();
                 let sel2 = $('slct2').val();
                $.ajax({
                     type: "post",
                     url:'/rempselect/'+selectedProject,
                     success:function(data) {
                         $('.slct2').html(data);
                         console.log(data);
                         $.ajax({
                            type: "post",
                            url:'/remptable/'+selectedProject+'/a',
                            success:function(result) {
                                $('.tbodycarte').html(result); 
                                // console.log(data) #}
                            }
                        })
                         // console.log(data) #}
                      }
                 })
                 
            }); 


             $('.slct2').on('change',function () {
                 let selectedProject = $('.slct').val();
                 let sel2 = $(this).val();
                $.ajax({
                     type: "post",
                     url:'/remptable/'+selectedProject+'/'+sel2,
                     success:function(data) {
                         $('.tbodycarte').html(data); 
                         console.log(data);
                      }
                 })
                 
            }); 

             
            $('body .dateC').on('change',function () {
                 let selectedProject = $('.dateC').val();
                 $.ajax({
                     type: "post",
                     url:'/remptablebydate/'+selectedProject,
                     success:function(data) {
                         $('.tbodycarte').html(data); 
                         console.log(data);
                      }
                 })
                 
            }); 
   
            $('body').on('click', '.tbodyFamille tr',function () {
                 $('body .tbodyFamille tr').css('background-color', 'white');
                $(this).css('background-color', '#cacaca');
                tableData5 = $(this).children("td").map(function () {
                    return $(this).text();
                  }).get();

           
                 
            }); 

             
            $('body #supprimerFamille').on('click',function () {

               

                 let selectedProject = $('body .ID_Famille').val();
                 // alert(selectedProject); #}
                 $.ajax({
                     type: "post",
                     url:'/Suppfamille/'+selectedProject,
                     success:function(data) {
                         window.location.href = window.location.href;
                      }
                 })
                 
            }); 


             
            $('body .famillemodifier').on('click',function () {

                 $.ajax({
                     type: "post",
                     url:'/modifmodalfamille/'+tableData5[0],
                     success:function(data) {
                         $('.modif-modal').html(data); 
                         console.log(data);
                      }
                 })
                 
            }); 

    // {# ===================== script on change ddl bénéficiaire par selection client popup ajouter carte ==================== #}
   // {# =============================================================================================== #}
             $('.selectclientadd').on('change',function () {
                 let selectedProject = $(this).val();
                $.ajax({
                     type: "post",
                     url:'/rempselectadd/'+selectedProject,
                     success:function(data) {
                         $('.selectbenefadd').html(data);
                         console.log(data);
                      }
                 })
                 
            }); 

   // {# ===================== script on change ddl tarif par selection Beneficiaire popup ajouter carte==================== #}
   //   {# =================================================================================================================== #}
               //      $('.selectbenefadd').on('change',function () {
               //      //     let selectedProject = $(this).val();
               //         $.ajax({
               //              type: "post",
               //              url:'/rempselecttarifadd',
               //              success:function(data) {
               //                  $('.selecttarifadd').html(data);
               //                  console.log(data);
               //               }
               //          })
                        
               //     }); 

               $('body' ).on('change','.selectclientmodif',function () {
               
                    let selectedProject = $(this).val();
                    
                   $.ajax({
                        type: "post",
                        url:'/rempselectmodif/'+selectedProject,
                        success:function(data) {
                            $('body .selectbenefmodif').html(data);
                            console.log(data);
                         }
                    })
                    
               }); 

                   
     // ===================== script on change ddl tarif par selection Beneficiaire popup ajouter carte==================== #}
     // =================================================================================================================== #}
             $('body').on('change','.slctC',function () {
                 
               let selectedProject = $(this).val();
               
              $.ajax({
                   type: "post",
                   url:'/rempselectbeneffact/'+selectedProject,
                   success:function(data) {
                       $('.slctB').html(data);
                       console.log(data);
                    }
               })
               
          }); 


            // ===================== script on change ddl tarif par selection Beneficiaire popup ajouter carte==================== #}
     // =================================================================================================================== #}
     // $('.slctB').on('change',function () {
     //      let selectedProject = $(this).val();
     //     $.ajax({
     //          type: "post",
     //          url:'/rempselecttariffacturer/'+selectedProject,
     //          success:function(data) {
     //              $('.selectF').html(data);
     //              console.log(data);
     //           }
     //      })
          
     // }); 



    // ===================== script on click valider ==================== #}
    // =============================================================================================== #}

    $('body').on('click','.valider',function () {

     let selectedProject = $(this).attr("data-id");
     window.open('/valider/'+tableData[0]);
     
    
});



   // ===================== script on click recherche on change tbody liste carte==================== #}
     // =================================================================================================================== #}
     $('body').on('click','.btncherchercarte',function () {
                 
          let DateD = $('#lbldatedebut').val();
          let DateF =  $('#lbldatefin').val();
          let Client = $('.slctC').val();
          let Benef  = $('.slctB').val();  
          let typeC =   $('.selecttariffacturer').val();         
         $.ajax({
              type: "post",
              url:'/rechercheCarte',
              data :{
                  'DateD':DateD,
                  'DateF':DateF,
                  'Client':Client,
                  'Benef':Benef,
                  'typeC' : typeC
              },
              success:function(data) {
                  $('.tbodylstcarte').html(data);
                  console.log(data);
               }
          })
          
     }); 

//{# ==============================script on change qte commande enregistre table================================ #}  
  //  {# =============================================================================================== #}  
            
             $('body').on('change','.paxRep',function () {
                 
             
                idcarte=$(this).parent().parent().find('td:eq(1)').text();
                
                idrepartition=$(this).parent().parent().find('td:eq(2)').text();
                 qtes=$(this).val();
                      $.ajax({
                        type: "POST",
                        url:'/updatepaxrep',
                         data: {
                             'qtes':qtes,
                             'idcarte':tableData[0],
                             'idrepartition':tableData2[0],
                         },
                        success:function(data) {
                         //   {# alert("l3ez"); #}
                       $.ajax({
                     type: "POST",
                     url:'/remplirtablerepar/'+tableData[0],
                     success:function(data) {
                          $('.tbody').html(data);
                         console.log(data)
                      }
                 })
                                                 }
                              }) 
                                     
               

            });   


 ////////////// {# ===================== script on click produit afficher dans le tableau ==================== #
 ////////////// {# =============================================================================================== #}
        
        
                   $('body').on('click','.selectproduct',function () {
                       
                        $('.selectproduct').css('background-color', '#f8f9fa');
                         $(this).css('background-color','#cacaca');
                        
                        let idproduit = $(this).find('a').attr('data-id');
                        let nomproduit = $(this).find('p').text();
               
                        
                        let nbrrow= $('.tbodyproduitadd tr > td:contains('+idproduit+') ').length;
                        if(nbrrow==0){
                             $('.tbodyproduitadd tr:last').after('<tr><td>'+idproduit+'</td><td>'+nomproduit+'</td><td><input type="text"/></td></tr>');
                        }
                        else{
                            alert("produit deja choisi");
                        }
                        
                    });            



   //         {# ===================== script recupere valeur popup ajouter repartion ==================== #}
     //       {# =============================================================================================== #}
        
                  $('body').on('click','.btnajoutercarteadd',function () {
                     //   {# e.preventDefault(); #}
                        let idcarte = $(this).attr("data-id");
                      
                        let i =$('.checklibelle').filter(':checked').length;
                         var selected = new Array();
                        var searchIDs = $('.checklibelle').filter(':checked').map(function(){
                         return $(this).val();
                        }).get();
                        for(j=0;j<=i-1;j++){
                             
                              $.ajax({
                                type: "POST",
                                url:'/addrapartition',
                                 data: {
                                     'i' : i,
                                     'idcarte':idcarte,
                                     'libelle' :searchIDs[j],
                                 },
                                success:function(data) {
                                      $('.btn-close').click();
                                     $.ajax({
                                         type: "POST",
                                         url:'/remplirtablerepar/'+idcarte,
                                         success:function(data) {
                                         $('.tbody').html(data);
                                         console.log(data)
                                                                }
                                            })
                                                         }
                                      }) 
                                              }
                    });
     



   //                 {# ===================== script recupere valeur popup modifier repartion ==================== #}
     //               {# =============================================================================================== #}
                
                          $('body').on('click','.btnmodifiercarteadd',function () {
                                             
                              
                                let libelle = $('.libelleM').val();
                                let pax = $('.paxM').val();
                                let heure = $('.heureM').val()
                                
                               
                                      
                                      $.ajax({
                                        type: "POST",
                                        url:'/modifierrapartition',
                                         data: {
                                             'id':tableData2[0],
                                             'idcarte' : tableData[0],
                                              'libelle' : libelle,
                                              'pax' : pax,
                                              'heure' : heure ,
                                         },
                                        success:function(data) {
                                             $('.btn-close').click();
                                            $.ajax({
                                                 type: "POST",
                                                 url:'/remplirtablerepar/'+tableData[0],
                                                 success:function(data) {
                                                 $('.tbody').html(data);
                                                 console.log(data)
                                      }
                                 })
                                        }
                                      })
                
                            });

 
                

   //                         {# ===================== script on click repartition ==================== #}
   //                         {# =============================================================================================== #}
                        
                                  $('body').on('click','.printreparition',function () {
                        
                                   
                        
                                    if(tableData[0] =="undefined" && tableData2[1]=="undefined"){
                                        alert("selectionnez une repartition");
                                    }
                                    else{
                                       
                                         window.open('/repartition/'+tableData[0]+'/'+tableData2[0]);
                                    }
                                        
                                    });
                        
                        
  
      //                              {# ===================== script recupere valeur popup supprimer repartion ==================== #}
      //                              {# =============================================================================================== #}
                                
                                          $('body').on('click','.btnsupprimercarteadd',function () {
                                                             
                                                      
                                                      $.ajax({
                                                        type: "POST",
                                                        url:'/deleterapartition',
                                                         data: {
                                                             'idcarte':tableData[0],
                                                              'idrepartition':tableData2[0],
                                                              
                                                         },
                                                        success:function(data) {
                                                             $('.btn-close').click();
                                                            $.ajax({
                                                                 type: "POST",
                                                                 url:'/remplirtablerepar/'+tableData[0],
                                                                 success:function(data) {
                                                                 $('.tbody').html(data);
                                                                 console.log(data)
                                                      }
                                                 })
                                                        }
                                                      })
                                
                                            });



///////////////////////////////////////////// {# ===================== script on click B2C ==================== #}
   /////////////////////////////////////////////{# =============================================================================================== #}
                                        
                                                  $('body').on('click','#b2c',function () {
                                                         window.open('/B2C/'+tableData[0]);
                                                    });
                                

    ///////////////////////////////////// {# ===================== script recupere valeur popup ajouter produit ==================== #}
    /////////////////////////////////////{# =============================================================================================== #}

          $('body').on('click','.btnajouterproduiteadd',function () {
                let idproduit ;
                let i =$('.tbodyproduitadd tr').length;
                let carte = tableData[0];
                let repartitio = tableData2[0];

               
         
                
                idproduit=$('.tbodyproduitadd tr').find('td:first-child').map(function(){
                 return $(this).text();
                }).get();
                 qteP=$('.tbodyproduitadd tr').find('td:eq(2)').map(function(){
                 return $(this).find('input').val();
                }).get();
                 for(j=0;j<=i-2;j++){
                  //  alert(repartitio);
                      $.ajax({
                        type: "POST",
                        url:'/addproduitcarte',
                         data: {
                             'idproduit':idproduit[j],
                             'idcarte' : carte,
                             'idrepartition' : repartitio,
                             'qtep':qteP[j],
                         },
                        success:function(data) {
                            
                            $('.btn-close').click();
                             $.ajax({
                                 type: "POST",
                                  url:'/remplirtablepro/'+tableData2[0],
                                 success:function(data) {
                                  $('.tbody2').html(data);
                      }
                 })
                                                 }
                              }) 
                                      }
              
            });





//------------------------------ modal cart ------------------------------------------------------------------------------------------------//            
            
            $('body .creer').on('click',function () {
                 

               $('#btnajoutercarte').modal('toggle');
               $('#btnajoutercarte').modal('show');
               
                 
            }); 

            $('body .validerP').on('click',function () {
                 

               $('#btnpopupvalider').modal('toggle');
               $('#btnpopupvalider').modal('show');
               
               $.ajax({
                    type: "POST",
                    url:'/remplirtbodyrep/'+tableData[0],
                    success:function(data) {
                         $('.tbodyrep').html(data);
                        console.log(data)
                     }
                })
                 
            }); 

            $('body .modifier').on('click',function () {
                
               // let selectedProject = $(this).find("td").attr("data-id");

               $('#btnsupprimerrepartition').modal('toggle');
               $('#btnsupprimerrepartition').modal('show');
               $.ajax({
                    type: "post",
                    url:'/modifmodalcarte/'+tableData[0],
                    success:function(data) {
                        $('.popupsupprimerrepartition').empty().append(data);; 
                    //     console.log(data);
                         
                      
               
                     }
                })
            }); 
       //------------------------------ modal Supprimer ------------------------------------------------------------------------------------------------//            


          

            $('body .supprimer').on('click',function () {
                
               $('#btnsuppercarte').modal('toggle');
               $('#btnsuppercarte').modal('show');
                $.ajax({
                    type: "post",
                    url:'/suppmodalcarte/'+tableData[0],
                    success:function(data) {
                        $('.popupsuppcarte').empty().append(data);
                        console.log(data);
                     }
                })
                
           }); 
      //------------------------------ modal Facturer ------------------------------------------------------------------------------------------------//            


          

            $('body .facturer').on('click',function () {
                
               $('#btnfacturer').modal('toggle');
               $('#btnfacturer').modal('show');
               
                
           }); 





//------------------------------ modal Repartition ------------------------------------------------------------------------------------------------//            


$('body .repartitioncreer').on('click',function () {
                 

     $('#btnajouterrepartition').modal('toggle');
     $('#btnajouterrepartition').modal('show');
     
       
 
     $.ajax({
          type: "POST",
          url:'/remplirpopupajouterrepar/'+tableData[0],
          success:function(data) {
              $('.popupajoutercarterepartition').empty().append(data);
            
          }
        })

     
  }); 


   //                  {# ===================== script on change popup modifier repartion par selection repartition et bnt modifier ==================== #}
    //                {# =============================================================================================== #}
                
    $('body').on('click', '.repartitionmodifier',function () {
     $('#btnmodifierrepartition').modal('toggle');
     $('#btnmodifierrepartition').modal('show');
                    //     alert(tableData2[0])    ;
                                 
     $.ajax({
         type: "POST",
         url:'/remplirpopupmodifierrepar/'+tableData2[0],
         success:function(data) {
              $('.popupmodifierrepartition').empty().append(data);
          //    console.log(data)
          }
     })
});


///////////////{# ===================== script on change popup supprimer repartion par selection repartition et bnt supprimer ==================== #}
///////////////{# =============================================================================================== #}
                                
$('body').on('click', '.supprimerrepartition',function () {

     $('#btnsupprimerrepartition').modal('toggle');
     $('#btnsupprimerrepartition').modal('show');
                                                                                                                        
     $.ajax({
         type: "POST",
         url:'/remplirpopupsupprimerrepar/'+tableData2[0],
         success:function(data) {
              $('.popupsupprimerrepartition').empty().append(data);
             
          }
     })
});


////////////////////////////////////:{# ===================== script on change papup calucul par selection repartion ==================== #}
//////////////////////////////////////{# =============================================================================================== #}

        $('body').on('click','.calc',function () {
       
          $('#btnCalc').modal('toggle');
          $('#btnCalc').modal('show');
          // alert(tableData2[0]);
             $.ajax({
                 type: "POST",
                 url:'/remplirpopupcalcul/'+tableData2[0],
                 success:function(data) {
                      $('.tbodycalcul').empty().append(data);
                  }
             })
        });
// ============================== recharger ================================

$('body').on('click','.rechargeC',function () {
       
     $('#btnrecharger').modal('toggle');
     $('#btnrecharger').modal('show');
     // alert(tableData2[0]);
      
   });

////////////////////////////////////:{# ===================== script on change papup calucul par selection repartion ==================== #}
//////////////////////////////////////{# =============================================================================================== #}

        
                                                           $('body').on('click', '.creerproduit',function () {

                                                            $('#btnajouterproduitrepartition').modal('toggle');
                                                            $('#btnajouterproduitrepartition').modal('show');
                                                
                                                                 $.ajax({
                                                                     type: "POST",
                                                                     url:'/remplirpopupajouterprod',
                                                                     data: {
                                                                             'idcarte':tableData[0],
                                                                              'idrepartition':tableData2[0],
                                                                         },
                                                                     success:function(data) {
                                                                          $('.popupajouterproduit').empty().append(data);
                                                                      }
                                                                 })
                                                            });       
                                                            
                                                            








  ////////////////////////////////////////////////////////////////////  BASE 2  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                                                          
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                                                          



     $('#myModal').on('shown.bs.modal', function(){
     $('#myInput').trigger('focus');
 });
  $('#btnFermer').click(function(){ 
 location.href = "product.html#tab4";
});




//{# ===================== script on change nav sous famille par selection famille product  ==================== #}
//{# ===================================================================================================== #}

$('body').on('click','.navIMGG',function () {


let selectedProject = $(this).find("a").attr("data-id");
$.ajax({
  type: "POST",
  url:'/remplirtableSFP/'+selectedProject,
  
  success:function(data) {
       $('.navSFP').html(data);
      console.log(data)
   }
})
});


//{# ===================== script on change espace produit par selection sous famille ==================== #}
//{# =============================================================================================== #}

$('body').on('click','.navImgProduit42_',function () {
// $(this).css('background-color', '#f8f9fa');

let selectedProject = $(this).find("a").attr("data-id");
$.ajax({
  type: "POST",
  url:'/remplirtablePP/'+selectedProject,
  data:{
     'id':tableData[0],
  },
  
  
  success:function(data) { 
       $('.espaceproduit').html(data);
      console.log(data)
   }
})
});



//{# ===================== script recupere valeur popup ajouter produit product ==================== #}
//{# =============================================================================================== #}

      $('body').on('click','.BTNAJTPR',function () {
            
           let idproduit=$('body .IDPR').val();
           let produit=$('body .PRR').val();
           let sousfamille=$('body .SFM').val();
           let typeproduit=$('body .TPR').val();
           let standard=$('body #1').val();
           let B2B=$('body #2').val();
           let thospital=$('body #3').val();
          
//visible//
           if( $('input[name=visible]').is(':checked') ){
               var visible = 1;
           } else {
               var visible = 0;

           }
//accomp//           
           if( $('input[name=accomp]').is(':checked') ){
               var accomp = 1;
           } else {
               var accomp = 0;
           }
//choix//           
           if( $('input[name=choix]').is(':checked') ){
               var choix = 1;
          } else {
              var choix = 0;
           }

           
           
          // alert(visible);
          // alert(accomp);
          // alert(choix);
          let i =$('.tbodytarif tr').length;
           let tarif=$('body .tbodytarif tr').find('td:eq(1)').map(function(){
             return $(this).find('input').val();
            }).get(); 
            let idtarif=$('body .tbodytarif tr').find('td:eq(0)').map(function(){
             return $(this).attr('data-id');
            }).get(); 
          
                  $.ajax({
                    type: "POST",
                    url:'/addproduitproduct',
                     data: {
                         'idproduit':idproduit,
                         'produit' : produit,
                         'sousfamille' : sousfamille,
                         'typeproduit':typeproduit,
                         'visible':visible,
                         'accomp':accomp,
                         'choix':choix,
                         'standard':standard,
                         'B2B':B2B,
                         'thospital':thospital,
                     },
                    success:function(data) {

                         $.ajax({
                                type: "POST",
                                 url:'/remplirtableProduit/'+sousfamille,
                                               
                                               success:function(data) {   if(data == 'ok'){
                                                             alert('produit ajouter avec success');
                                                         }
                                                    $('.modalajouter').modal('hide');  
                                                    $('.tbodyProduit').html(data);
                                                   console.log(data)
                                                }
                                           })


                 }
                          }) 
                                 
          
        });


     //    {# =====================script on click tr produit ======================= #}  
     //    {# =============================================================================================== #}  
    
    
              $('body').on('click','.tbodyProduit tr',function () {
                    $('.tbodyProduit tr').css('background-color', 'white');
                    $(this).css('background-color', '#cacaca');
                    tableData3 = $(this).children("td").map(function () {
                         return $(this).text();
                       }).get();
                      
                 
                    
                });

  //    {# =====================script on click row produit remplissage modal modifier ======================= #}  
     //    {# =============================================================================================== #}  
    

              $('body').on('click','.produitedit',function () {                    
                     $.ajax({
                         type: "post",
                         url:'/rempmodalmodifPP/'+tableData3[1],
                         success:function(data) {
                             $('.modalmodifpro').html(data); 
                             console.log(data);
                          }
                     })
                    
                });


// {# ===================== script on click produit supprimer du le tableau ==================== #}
// {# =============================================================================================== #}


       $('body').on('dblclick','.tbodyproduitadd tr',function () {
           
             $('.tbodyproduitadd tr:last').remove();

        
        });

        
//     {# ==============================script on change qte commande================================ #}  
//     {# =============================================================================================== #}  
             
            $('body').on('change','.qteC',function () {
                let qtec = $(this).val();
                let qtes= $(this).parent().parent().find("td:eq(4)").find('input').val();    
                
                if(qtec < qtes){
                     let qter;  
                qter=qtes-qtec;
                $(this).parent().parent().find('.qteR').val(qter);
                }
                else{
                    alert("la quantite commande est superieure a la quantite en stock !!!");
                }
               

            }); 




          //   {# ==============================script on change qte commande enregistre table================================ #}  
          //   {# =============================================================================================== #}  
                    
                     $('body').on('click','.btnfermerpro',function () {
                         
                       let i =$('.tbodycalcul tr').length;
                    //    alert(i);
                    //     idrepartition=$('.tbodycalcul tr').find('td:first-child').map(function(){
                    //      return $(this).text();
                    //     }).get();
                        idcartelg=$('.tbodycalcul tr').find('td:eq(0)').map(function(){
                         return $(this).text();
                        }).get();
                         qtes=$('.tbodycalcul tr').find('td:eq(4)').map(function(){
                         return $(this).find('input').val();
                        }).get();
                        qtec=$('.tbodycalcul tr').find('td:eq(5)').map(function(){
                         return $(this).find('input').val();
                        }).get();
                        qter=$('.tbodycalcul tr').find('td:eq(6)').map(function(){
                         return $(this).find('input').val();
                        }).get();
                        
                        
        
                         for(j=0;j<=i-1;j++){
                             
                              $.ajax({
                                type: "POST",
                                url:'/updateqteproduit',
                                 data: {
                                     'qtec':qtec[j],
                                      'qtes':qtes[j],
                                      'qter' : qter[j],
                                      'idcartelg':idcartelg[j],
                                      'idrepartition' : tableData2[0],
                                 },
                                success:function(data) {
                                   //  {# alert("l3ez"); #}
                                    $('.btn-close').click();
                                 
                                                         }
                                      }) 
                                              } 
                       
        
                    });   
        
        
             ///////////////////////////////////:{# ===================== script on change papup calucul par selection repartion ==================== #}
//////////////////////////////////////{# =============================================================================================== #}


          $('body').on('click','.produitdelete',function () {
               
                 $.ajax({
                     type: "post",
                     url:'/rempmodalsupprimerPP/'+tableData3[1],
                     success:function(data) {
                         $('.modalsupppro').html(data); 
                         console.log(data);
                      }
                 })
                
            });

        $('body').on('click','.supprimerproc',function () {
       
          $('#btnsupprimerproduitpro').modal('toggle');
          $('#btnsupprimerproduitpro').modal('show');
          // alert(tableData2[0]);
             $.ajax({
                 type: "POST",
                 url:'/remplirpopupsupprimerpro/'+tableData3[0],
                 success:function(data) {
                      $('.popupsupproduit').empty().append(data);
                  }
             })
        });



               //  {# ==============================script on click modifier produit product================================ #}  
               //  {# =============================================================================================== #}  
                         
                        $('body').on('click','.btnmodpro',function () {
            
                             let npro = $('body .NPro').val();
                             $.ajax({
                                 type: "post",
                                 url:'/modpro/'+tableData3[0],
                                 data:{
                                     'idsf':tableData3[1],
                                     'npro':npro
                                 },
                                 success:function(data) {
                                   $('body .tbodyProduit').html(data);
                                   console.log(data)
                                     $('.btn-close').click();
                                     
                        
                                 }
                             })
                        }); 
            
    
  /////////////////////// {# ==============================script on click supprimer produit product================================ #}  
  /////////////////////// {# =============================================================================================== #}  
                                 
                                $('body').on('click','.btnsupppro',function () {
                    
                                     let selectedProject = $('body .idproduit').val();
                                     let selectedProject2 = $('body .btnsupppro').attr('data-id');
                                     
                                     $.ajax({
                                         type: "post",
                                         url:'/Supppro/'+tableData3[0],
                                         data:{
                                             'idsf':selectedProject2,
                                         },
                                         success:function(data) {
                                             $('.btn-close').click();
                                            $.ajax({
                                         type: "POST",
                                         url:'/remplirtableProduit/'+selectedProject2,
                                         
                                         success:function(data) { 
                                              $('.tbodyProduit').html(data);
                                             console.log(data)
                                          }
                                     })
                                         }
                                     })
                                }); 
                    

//////////////////////////////// {# =====================script on click row sous famille remplissage modal supp ======================= #}  
/////////////////////////////////{# =============================================================================================== #}  
                                         
                                        $('body ').on('click','.tbodySousFamille tr',function () {
                            
                                             $('.tbodySousFamille tr').css('background-color', 'white');
                                            $(this).css('background-color', '#cacaca');
                            
                                             let selectedProject = $(this).find('td:first-child').text();
                                             
                                             tableData4 = $(this).children("td").map(function () {
                                                  return $(this).text();
                                                }).get();


                                             
                                        }); 
                            

     //    {# ===================== script recupere valeur popup supprimer produit ==================== #}
     //    {# =============================================================================================== #}
    
              $('body').on('click','.btnsuppro',function () {
                    // {# e.preventDefault(); #}
                                 
                    // let idproduit = $('.idproduitp').attr("data-id");
                    // let idrepartition = $('.idrepp').attr("data-id");
                   
                   
                          
                          $.ajax({
                            type: "POST",
                            url:'/deleteproduitrepartition/'+tableData3[0],
                         //     data: {
                         //         'idproduit':idproduit,
                               'idrepartition':tableData2[0],
                                  
                         //     },
                            success:function(data) {
                                 $('.btn-close').click();
                                   //  {# return false; #}
                                    $.ajax({
                                     type: "POST",
                                      url:'/remplirtablepro/'+tableData2[0],
                                     success:function(data) {
                                      $('.tbody2').html(data);
                                     console.log(data)
                          }
                     })
                            }
                          })
    
                });
    


  ///////////////////////////////// {# ===================== script on change champs id famille par selection famille popup update ==================== #}
////////////////////////////////   {# ===================================================================================================== #}
                                    
                                                  $('body ').on('click','.sfmodifier',function () {
                                    
                                                  
                                                     $.ajax({
                                                         type: "post",
                                                         url:'/rempmodalmodifSF/'+tableData4[1],
                                                         success:function(data) {
                                                             $('.modalmodifSF').html(data); 
                                                             console.log(data);
                                                          }
                                                     })
                                                     
                                                }); 

 ///////////////////////////////////////////////{# ==============================script on click supprimer sous famille================================ #}
 ///////////////////////////////////////////////{# =============================================================================================== #}  
                                                         
                                                        $('body').on('click',' #btnaddpro',function () {
                                            
                                                             var idfamille = $('body #sfamille').val();
                                                             let idsousfamille = $('body .idsousfamilleA').val();
                                                             let sousfamille = $('body .sousfamilleA').val();
                                                             let farab = $('body .farabeA').val();
                                                             
                                                             $.ajax({
                                                                 type: "post",
                                                                 url:'/addSousFamille',
                                                                 data:{
                                                                     'idfamille':idfamille,
                                                                     'idsousfamille':idsousfamille,
                                                                     'sousfamille':sousfamille,
                                                                     'farab':farab,
                                                                 },
                                                                 success:function(data) {
                                                                     $('.btn-close').click();
                                                                     $.ajax({
                                                                        type: "POST",
                                                                        url:'/remplirtableSousFamille/'+idfamille,
                                                                        
                                                                        success:function(data) {
                                                                            $('.tbodySousFamille').html(data);
                                                                            console.log(data)
                                                                        }
                                                             })
                                                                  }
                                                             })
                                                             
                                                        }); 

 ///////////////////////////////////////////////{# ==============================script on click ajouter famille================================ #}
 ///////////////////////////////////////////////{# =============================================================================================== #}  
                                                         
                                                        $('body').on('click',' .familleajouter',function () {
                                            
                                                             var famille = $('body #familles').val();
                                                             var typefamille = $('body #typefamille').val();
                                                             var famillearabe = $('body #famillearabe').val();
                                                             
                                                             $.ajax({
                                                                 type: "post",
                                                                 url:'/addfamille',
                                                                 data:{
                                                                     'famille':famille,
                                                                     'typefamille':typefamille,
                                                                     'famillearabe':famillearabe,
                                                                    
                                                                 },
                                                                 success:function(data) {
                                                                      $('body .tbodyFamille').html(data);
                                                                      console.log(data)
                                                                     $('.btn-close').click();
                                                              
                                                                  }
                                                             })
                                                             
                                                        }); 
                                            
  
     //  {# ===================== script on click facturer ==================== #}
     //  {# =================================================================================================================== #}
               $('body').on('click','.btnajouterfacture',function () {
                    let DateD = $('.dateda').val();
                    let DateDeut = $('#lbldatedebut').val();
                    let Datefin = $('#lbldatefin').val();
                    let DateF =  $('.numda').val();
                    let Client = $('.slctC').val();
                    let Benef  = $('.slctB').val();  
                    let typeC =   $('.selecttariffacturer').val();  
     
                    let i =$('.checklibelle2').filter(':checked').length;
                    var selected = new Array();
                    var searchIDs = $('.checklibelle2').filter(':checked').map(function(){
                    return $(this).val();
                    }).get();

                    if ($('input.recharge').is(':checked')) {
                         $('.btn-close').click();
                         window.open('/recharge/'+DateDeut+'/'+Datefin+'/'+DateF+'/'+DateD);
                       

                         }

                    else{
                           
                         $.ajax({
                              type: "post",
                              url:'/ajouterfacture',
                              data :{
                                   'DateD':DateD,
                                   'DDA':DateF,
                                   'Client':Client,
                                   'Benef':Benef,
                                   'typeC' : typeC
                              },
                              success:function(data) {
                                   console.log(data);
                                   // {# alert(data) #}
                                   let idfact= data;
                                   // alert(idfact);
                              for(j=0;j<=i-1;j++){
                              $.ajax({
                                   type: "post",
                                   url:'/facturation',
                                   data:{
                                        'idfact':idfact,
                                        'idcarte': searchIDs[j],
                                   },
                                   success:function(data) {
                                        console.log(data);
                                        $('.btn-close').click();
                                        window.open('/facturer/'+data);
                                   }
                                        })
                                             }
          
          
                              
                              }
                         })
                    }
               
                    
               });                                           
                
               $('.cardC').on('click', function () {
                    var idrepartition = $(this).attr("data-id");
                    $.ajax({
                         type: "post",
                         url:'/checkcommande/'+idrepartition,
                         success:function(data) {
                         location.href="http://127.0.0.1:8000/checkcommande/"+idrepartition
                          }
                     })
                  });

                  $('body').on('click', '.tabrowC tr',function () {

                    $.ajax({
                         type: "post",
                         url:'/detailCommande/'+tableData7[0],
                         // data:{
                         //     'idrepartition':idrepartition,
                         // },
                         success:function(data) {
                              $('.detailcommandeC').html(data);
                              console.log(data)
                          }
                     })
               });
               // "content-hash": "f01bea732c64de91fab9583201384b3b",

               $('body').on('click', '.btnimprimerrecu',function () {
                    window.open('/pdfrecu/'+tableData7[0]);
                    window.open('/pdfrecu/'+tableData7[0]);

                    
                    // $.ajax({
                    //      type: "post",
                    //      url:'/pdfrecu/'+tableData7[0],
                    //      // data:{
                    //      //     'idrepartition':idrepartition,
                    //      // },
                    //      success:function(data) {
                    //           // $('.detailcommandeC').html(data);
                    //           // console.log(data)
                    //       }
                    //  })
               });

               $('body').on('click', '.modifierfamille',function () {
                    var idfamille = $('#id-famille').val();
                    var famille = $('#famille').val();
                    var tfamille = $('#tfamille').val();
                    var farabe = $('#farabe').val();
                    
                    $.ajax({
                         type: "post",
                         url:'/modfam',
                         data:{
                             'idfamille':idfamille,
                             'famille':famille,
                             'tfamille':tfamille,
                             'farabe':farabe,
                         },
                         success:function(data) {
                              $('body .tbodyFamille').html(data);
                              console.log(data)
                            
                              $('#btnModifier').modal("hide");
                             
                          }
                     })
               });

               
     //  {# =================================================================================================================== #}
     //                                            Select detail + facture 
     //  {# =================================================================================================================== #}

     $('body').on('change', '.selectpicker',function () {
               val = $('.selectpicker').find('option:selected').attr('id');

               if (val == 1) {
                    window.open('/valider/'+tableData[0]);
                    

               }
               else if(val == 2){
                    alert('facture');

               }
               else if(val == 3){
                    alert('pee');

               }
                    // var idfamille = $('#id-famille').val();
                    // var famille = $('#famille').val();
                    // var tfamille = $('#tfamille').val();
                    // var farabe = $('#farabe').val();
                    // $.ajax({
                    //      type: "post",
                    //      url:'/modfam/'+idfamille,
                    //      data:{
                    //          'idfamille':idfamille,
                    //          'famille':famille,
                    //          'tfamille':tfamille,
                    //          'farabe':farabe,
                    //      },
                    //      success:function(data) {
                    //           alert('ok')
                             
                    //       }
                    //  })
               });


               $('body').on('click', '.btnmodifSF',function () {
                    var sousfamille = $('#sousfamille').val();
                    var Sidfamille = $('#Sidfamille').val();
                    var snarabe = $('#snarabe').val();
                  alert(sousfamille);
                    $.ajax({
                         type: "post",
                         url:'/modsfam',
                         data:{
                             'Sidfamille':Sidfamille,
                             'sousfamille':sousfamille,
                             'snarabe':snarabe,
                             'Famille':tableData4[0],
                         },
                         success:function(data) {
                              $('.tbodySousFamille').html(data);
                              $('#btnModifierSF').modal("hide");

                              
                             
                          }
                     })
               });





               $('body').on('click','.btnvaliderrecharge',function () {
       
                    var idrecharge = $('.idrechargeC').val();
                    // alert(tableData2[0]);
                       $.ajax({
                           type: "POST",
                           url:'/validerRecharge/'+idrecharge,
                           success:function(data) {
                              $('.btn-close').click();
                            }
                       })
                  });


                  $('body').on('dblclick', '.tbodyencours tr',function () {
                    var idope=$(this).find('td').find('h1').text();
                    $(this).hide();
                    $.ajax({
                         type: "post",
                         url:'/pretecommande/'+idope,
                         // data:{
                         //     'idrepartition':idrepartition,
                         // },
                         success:function(data) {
                              $('.tbodyprete').html(data);
                              console.log(data)
                          }
                     })
               });

               $('body').on('dblclick', '.tbodyprete tr',function () {
                    var idope=$(this).find('td').find('h1').text();
                    $(this).hide();
                    // alert(idope);
                    $.ajax({
                         type: "post",
                         url:'/servivommande/'+idope,
                         // data:{
                         //     'idrepartition':idrepartition,
                         // },
                         success:function(data) {
                              $('.tbodyprete').html(data);
                              console.log(data)
                          }
                     })
               });

               $('body').on('click','.returnMenu',function () {
       
                    // $('#btnrecharger').modal('toggle');
                    // $('#btnrecharger').modal('show');
                    // alert(tableData2[0]);
                    location.href="http://127.0.0.1:8000/caisse"
                     
                  });

//                  {# ===================== script on change navbar sous famille par selection famille ==================== #}
//                  {# =============================================================================================== #}
              
                           $('body').on('click','.navImgProduit',function () {

                               let selectedProject = $(this).find("a").attr("data-id");
                              
                               $.ajax({
                                   type: "POST",
                                   url:'/remplirNavSousFamille/'+selectedProject,
                                   
                                   success:function(data) {
                                        $('.navSF').html(data);
                                       console.log(data)
                                    }
                               })
                          });
              

          });

     // });