async function fetchData() {
    try {
      const response = await fetch('fetch_data.php');
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const data = await response.json();
      console.log('Fetched data:', data);  // Log fetched data

      const labels = data.map(item => item.timestamp);
      const brightnessData = data.map(item => item.brightness / 10);  // Scaling value for brightness
      const temperatureData = data.map(item => item.temperature / 10);  // Scaling value for temperature
      const tdsData = data.map(item => item.tds / 100);  // Scaling value for TDS

      return { labels, brightnessData, temperatureData, tdsData };
    } catch (error) {
      console.error('Error fetching data:', error);
      return { labels: [], brightnessData: [], temperatureData: [], tdsData: [] };
    }
  }

fetchData();

  async function renderChart() {
    const { labels, brightnessData, temperatureData, tdsData } = await fetchData();

    const ctx = document.getElementById('sensorChart').getContext('2d');
    const sensorChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Brightness (Scaled Value)',
            data: brightnessData,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            fill: false
          },
          {
            label: 'Temperature (Scaled Value)',
            data: temperatureData,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            fill: false
          },
          {
            label: 'Total Dissolved Solids (Scaled Value)',
            data: tdsData,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: false
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Values'
            }
          }
        },
        plugins: {
          legend: {
            labels: {
              generateLabels: function(chart) {
                return chart.data.datasets.map(function(dataset, i) {
                  return {
                    text: dataset.label.replace(' (Scaled Value)', ''),  // Remove '(Scaled Value)' from legend
                    fillStyle: dataset.borderColor,
                    hidden: !chart.isDatasetVisible(i),
                    datasetIndex: i
                  };
                });
              }
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || '';
                if (label) {
                  label += ': ';
                }
                if (context.parsed.y !== null) {
                  label += context.parsed.y;
                }
                return label;
              },
              afterLabel: function(context) {
                let additionalInfo = '';
                switch(context.dataset.label) {
                  case 'Brightness (Scaled Value)':
                    additionalInfo = 'Real Value: '+ (context.parsed.y * 10).toFixed(1) + ' lm';
                    break;
                  case 'Temperature (Scaled Value)':
                    additionalInfo = 'Real Value: '+ (context.parsed.y * 10).toFixed(1) + ' °C';
                    break;
                  case 'Total Dissolved Solids (Scaled Value)':
                    additionalInfo = 'Real Value: '+ (context.parsed.y * 100).toFixed(1) + ' ppm';
                    break;
                }
                return additionalInfo;
              }
            }
          }
        }
      }
    });
  }

renderChart();