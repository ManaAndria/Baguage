<?php
function add_script()
    {
        
    	             ?>
             <script src="https://code.jquery.com/jquery-2.1.0.min.js" integrity="sha256-8oQ1OnzE2X9v4gpRVRMb1DWHoPHJilbur1LP9ykQ9H0=" crossorigin="anonymous"></script>
             <script type="text/javascript">
        function temps(date)
        {
            var d = new Date(date[2], date[1] - 1, date[0]);
            return d.getTime();
        }

        function calculer(date1,date2) 
        {        
            var debut = temps(date1.split("/"));
            var fin = temps(date2.split("/"));
            nb = (fin - debut) / (1000 * 60 * 60 * 24); // + " jours";
            nb = Math.round(nb);
            return nb;
        }

        $(document).ready(function() {
            $('#btnFrmPicto input').click(function(e) {

                var date1=$('#form_dateDebut').val();
                var date2=$('#form_dateFin').val();
                var week = calculer(date1,date2);
                if(week < 7){
                    alert(__('Please select at least a period of 7 days.','Booking-search'));
                    return false;
                }
                return true;
            });
        });
    </script>
            
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery.ui.core.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery.ui.datepicker.min.js"></script>

            <script type="text/javascript">

              	$(function () {
				    $('#dateDebut').datepicker("option", "minDate",0);
				});

              	// make today button work
              	$.datepicker._gotoToday = function(id) { 
				    $(id).datepicker('setDate', new Date()).datepicker('hide').blur(); 
				};

          		<?php if (the_curlang() == 'fr_fr') { ?>

					$(document).ready(function() {

						$( "#form_dateDebut" ).datepicker({
					        altField: "#datepicker",
					        closeText: 'Fermer',
					        prevText: 'Précédent',
					        nextText: 'Suivant',
					        currentText: 'Aujourd\'hui',
					        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
					        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
					        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
					        dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
					        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
					        weekHeader: 'Sem.',
					        dateFormat: 'dd/mm/yy',
							minDate:0,
							//maxDate: 'today',
					        changeMonth: true,
					        showButtonPanel: true,
					        changeYear: true,        
					        onClose: function( selectedDate ) {
					            $( "#form_dateFin" ).datepicker( "option", "minDate", selectedDate );
					        }
					    });

						//Edigard le mois de la date fin doit etre égale à la date début : ex date debut :10/2016  => date fin 10/2016 
					 	$(document).on('click','#form_dateFin' ,function(){
					         
					        var dateEntree;
					        if( $('#form_dateDebut').val()!="")
					        {
						        j_entree=($('#form_dateDebut').val().substring(0,2));
						        m_entree=($('#form_dateDebut').val().substring(3,5));
						        a_entree=($('#form_dateDebut').val().substring(6));
					          
					         	dateEntree=new Date(a_entree,m_entree-1,j_entree);
					         	dateEntree.setTime(dateEntree.getTime() + 24 * 3600 * 1000);
					         	dateEntreePlusUnjr =new Date(dateEntree.getFullYear(),dateEntree.getMonth(),dateEntree.getDate())
					         
					         	$("#form_dateFin").datepicker().datepicker("setDate",dateEntreePlusUnjr); 
					     	}
					   	}); 
					    
						$( "#form_dateFin" ).datepicker({
					        altField: "#datepicker",
					        closeText: 'Fermer',
					        prevText: 'Précédent',
					        nextText: 'Suivant',
					        currentText: 'Aujourd\'hui',
					        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
					        monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
					        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
					        dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
					        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
					        weekHeader: 'Sem.',
					        dateFormat: 'dd/mm/yy',
							minDate:0,
							//maxDate: 'today',
					        changeMonth: true,
					        showButtonPanel: true,
					        changeYear: true,         
					        onClose: function( selectedDate ) {
					            // $( "#form_dateDebut" ).datepicker( "option", "minDate", selectedDate );
					        }
					    });

					});   
				<?php } else {?>
					//en_Us
					$(document).ready(function() {

						$( "#form_dateDebut" ).datepicker({
					        altField: "#datepicker",
					        weekHeader: 'Sem.',
					        dateFormat: 'dd/mm/yy',
							minDate:0,
							//maxDate: 'today',
					        changeMonth: true,
					        showButtonPanel: true,
					        changeYear: true,        
					        onClose: function( selectedDate ) {
					            $( "#form_dateFin" ).datepicker( "option", "minDate", selectedDate );
					        }
					    });

						//Edigard le mois de la date fin doit etre égale à la date début : ex date debut :10/2016  => date fin 10/2016 
					 	$(document).on('click','#form_dateFin' ,function(){
					         
					        var dateEntree;
					        if( $('#form_dateDebut').val()!="")
					        {
						        j_entree=($('#form_dateDebut').val().substring(0,2));
						        m_entree=($('#form_dateDebut').val().substring(3,5));
						        a_entree=($('#form_dateDebut').val().substring(6));
					          
					         	dateEntree=new Date(a_entree,m_entree-1,j_entree);
					         	dateEntree.setTime(dateEntree.getTime() + 24 * 3600 * 1000);
					         	dateEntreePlusUnjr =new Date(dateEntree.getFullYear(),dateEntree.getMonth(),dateEntree.getDate())
					         
					         	$("#form_dateFin").datepicker().datepicker("setDate",dateEntreePlusUnjr); 
					     	}
					   	}); 
					    
						$( "#form_dateFin" ).datepicker({
					        altField: "#datepicker",
					        weekHeader: 'Sem.',
					        dateFormat: 'dd/mm/yy',
							minDate:0,
							//maxDate: 'today',
					        changeMonth: true,
					        showButtonPanel: true,
					        changeYear: true,         
					        onClose: function( selectedDate ) {
					            // $( "#form_dateDebut" ).datepicker( "option", "minDate", selectedDate );
					        }
					    });

					});


				<?php } ?>
				
				


            </script>
        <?php
}