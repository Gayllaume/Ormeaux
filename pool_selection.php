	<?php
  include('./bdd/bdd_session.php')
  ?>

  <?php
	require_once 'php/header.php';
	?>

  <body>

    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script>
	<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/13.2.9/js/dx.chartjs.js"></script>

  <body>

  <?php
	require_once 'php/navbar.php';
	?>

  <?php
  $id = $_GET['id_bassins'];
  ?>

	</br>

	<div class="container">
		<div class="row">

		<?php

		echo '
				<div class="col col-sm-12 col-lg-6">
					<div class="row">
    					<div class="col-md-auto">
      						<h3>Bassin N°',$id,'</h3>
    					</div>
					</div>
				<hr>
  					<div class="row">
    					<div class="col col-sm-12 col-lg-12">
      						<div id="tempGaugeContainer',$id,'"></div>
    					</div>
    					<div class="col col-sm-12 col-lg-12">
      						<div id="debitGaugeContainer',$id,'"></div>
    					</div>
  					</div>
				</div>

        <div class="col col-sm-12 col-lg-6">
          <div class="row">
            <div class="col-md-auto">
              <h3>Historique</h3>
            </div>
            <div class="col"></div>
              <div class="col-md-auto">
                <div class="btn-group">
                  <button type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Période</button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Année</a>
                      <a class="dropdown-item" href="#">Mois</a>
                      <a class="dropdown-item" href="#">Jours</a>
                      <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Calendrier</a>
                      </div>
                    </div>
                  </div>
                </div>
              <hr>
                    <div class="row">
                        <div class="col col-sm-12 col-lg-12">
                            <canvas id="temp',$id,'" height="200"></canvas>
                        </div>
                        </br>
                        <div class="col col-sm-12 col-lg-12">
                            <canvas id="debit',$id,'" height="200"></canvas>
                        </div>
                    </div>
                </div>';
		  ?>

		</div>
	</div>
</div>

      <?php
        $servername = "ormeaux-29.mysql.database.azure.com";
        $username = "ormeaux@ormeaux-29";
        $password = "Password29";
        $dbname = "ormeaux";
        try
        {
            $pdo = new PDO("mysql:host={$servername};dbname={$dbname}",$username,$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $ex)
        {
            die($ex->getMessage());
        }
        $stat=$pdo->prepare('SELECT date, temperature, debit FROM mesures WHERE id_bassins='.$id.'');
        $stat->execute();
        $json=[];
        $json2=[];
        $json3=[];
        $temp=0;
        $debit=0;
        while ($row2=$stat->fetch(PDO::FETCH_ASSOC)) {
            extract($row2);
            $json[]=$date;
            $json2[]=(float)$temperature;
            $json3[]=(float)$debit;
            $temp=(float)$temperature;
            $debit=(float)$debit;
        }
      ?>

	<script type="text/javascript">
    var i = <?php echo json_encode($id); ?>;

		var tempvalues = <?php echo json_encode($temp); ?>;
		var debvalues = <?php echo json_encode($debit); ?>;


		$("#tempGaugeContainer"+i).dxCircularGauge({
  		rangeContainer: { 
   		offset: 10,
    		ranges: [
      			{ startValue: 20, endValue: 25, color: '#2DD700' },
     			{ startValue: 25, endValue: 30, color: '#FF0000' }
    				]
  		},

  			scale: {
    			startValue: 0,  endValue: 30,
    			majorTick: { tickInterval: 30 },
    			label: {
      				format: '',
    			}
  		},

  			title: {
    			text: 'TEMP : '+ tempvalues + ' °C',
    			fontFamily: "Arial",
    			position: 'bottom-center'
  		},

  			tooltip: {
				enabled: true,
    			format: '',
					customizeText: function (arg) {
						return  arg.valueText + ' °C';
				}
		},

  		value: tempvalues,
  		subvalues: [tempvalues]

	});
	
		$("#debitGaugeContainer"+i).dxCircularGauge({
  		rangeContainer: { 
    	offset: 10,
    		ranges: [
      			{ startValue: 20, endValue: 25, color: '#00BFFF' },
      			{ startValue: 25, endValue: 60, color: '#00BFFF' }
    				]
 		},

  			scale: {
    			startValue: 0,  endValue: 60,
    			majorTick: { tickInterval: 60 },
    			label: {
      				format: ''
    			}
  		},

  			title: {
    			text: 'DEBIT : '+ debvalues + ' L/m',
    			subtitle: 'test',
    			position: 'bottom-center',
  		},

  			tooltip: {
				enabled: true,
    			format: '',
					customizeText: function (arg) {
						return  arg.valueText + ' L/m';
				}
		},

  		value: debvalues,
  		subvalues: [debvalues]
	});

</script>

<script src="path/to/chartjs/dist/Chart.js"></script>
<script>
var i = <?php echo json_encode($id); ?>;

var ctx = document.getElementById('temp'+i).getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($json); ?>,
        datasets: [{
            label: "Température en °C",
            borderColor: 'rgb(205,92,92)',
            data: <?php echo json_encode($json2); ?>,
        }]
    },

    // Configuration options go here
    options: {
      scales: {
        yAxes: [{
          ticks: {
            suggestedMin: 0,
            suggestedMax : 30
          }
        }]
      }
    }
});

var ctx = document.getElementById('debit'+i).getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($json); ?>,
        datasets: [{
            label: "Débit en L/m",
            borderColor: 'rgb(100,149,237)',
            data: <?php echo json_encode($json3); ?>,
        }]
    },

    // Configuration options go here
    options: {
      scales: {
        yAxes: [{
          ticks: {
            suggestedMin: 0,
            suggestedMax : 60
          }
        }]
      }
    }
});
</script>

</br>

</body>
</html>

