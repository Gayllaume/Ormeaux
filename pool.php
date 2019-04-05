	<?php
	include('bdd/bdd_session.php')
	?>

	<?php
	require_once 'php/header.php';
	?>

	<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script>
	<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/13.2.9/js/dx.chartjs.js"></script>

  <body>

  <?php
	require_once 'php/navbar.php';
	?>

	</br>

	<div class="container">
		<div class="row">

    <?php

        require_once './bdd/bdd_config.php';

        $sql = "SELECT id_bassins FROM mesures GROUP BY ID_BASSINS";
        $result = $conn->query($sql);
        if(!$result)
        {
          echo "Pas de résultat";
        }
        else
        {
            if($result->num_rows>0)
            {
              while ($row = $result->fetch_assoc()) {
              $id = $row["id_bassins"];

              echo '</br>
                  <div class="col-12 col-sm-12 col-lg-6">
                    <div class="row">
                      <div class="col-md-auto">
                        <h3>Bassin N°',$id,'</h3>
                      </div>
                    <div class="col"></div>
                    <div class="col-md-auto">
                      <a href="pool_selection.php?id_bassins='.$id.'"><button type="text" class="btn btn-outline-primary">Historique</button></a>
                    </div>
                  </div>
                <hr>
                  <div class="row">
                    <div class="col col-sm-12 col-lg-6">
                      <div id="tempGaugeContainer',$id,'"></div>
                    </div>
                    <div class="col col-sm-12 col-lg-6">
                      <div id="debitGaugeContainer',$id,'"></div>
                    </div>
                  </div>
                </div>';

    ?>

	<script type="text/javascript">
    
	var i = <?php echo json_encode($id); ?>;

		var tempvalues = 20;
		var debvalues = 50;


		$("#tempGaugeContainer"+i).dxCircularGauge({
  		rangeContainer: { 
   		offset: 10,
    		ranges: [
      			{ startValue: 20, endValue: 25, color: "#2DD700" },
     			  { startValue: 25, endValue: 30, color: "#FF0000" }
    				]
  		},

  			scale: {
    			startValue: 0,  endValue: 30,
    			majorTick: { tickInterval: 15 },
    			label: {
      				format: '',
    			}
  		},

  			title: {
    			text: "TEMP : "+ tempvalues + " °C",
    			fontFamily: "Arial",
    			position: "bottom-center"
  		},

  			tooltip: {
				enabled: true,
    			format: '',
					customizeText: function (arg) {
						return  arg.valueText + " °C";
				}
		},

  		value: tempvalues,
  		subvalues: [tempvalues]

	});
	
		$("#debitGaugeContainer"+i).dxCircularGauge({
  		rangeContainer: { 
    	offset: 10,
    		ranges: [
      			{ startValue: 25, endValue: 60, color: "#00BFFF" }
    				]
 		},

  			scale: {
    			startValue: 0,  endValue: 60,
    			majorTick: { tickInterval: 30 },
    			label: {
      				format: ""
    			}
  		},

  			title: {
    			text: "DEBIT : "+ debvalues + " L/m",
    			subtitle: "test",
    			position: "bottom-center",
  		},

  			tooltip: {
				enabled: true,
    			format: '',
					customizeText: function (arg) {
						return  arg.valueText + " L/m";
				}
		},

  		value: debvalues,
  		subvalues: [debvalues]
	});

	</script>

  <?php
          }
        }
      
      };
  ?>

    </div>
  </div>


  </body>
</html>