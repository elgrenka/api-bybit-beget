document.addEventListener('DOMContentLoaded', function () {

    fetch('get_candles.php')
        .then(response => response.json())
        .then(data => {
            const chartOptionsCandle = {
                layout: {
                    background: { color: '#777' },
                    textColor: '#ddd',
                },
                grid: {
                    vertLines: { color: '#999' },
                    horzLines: { color: '#999' },
                },
            };

            const chartCandle = LightweightCharts.createChart(
                document.getElementById('container-candle'), chartOptionsCandle,
            );

            const candleSeries = chartCandle.addCandlestickSeries();
            candleSeries.setData(data.candle);
            chartCandle.timeScale().fitContent();

            const chartOptionsLine = {
                layout: {
                    textColor: 'black',
                    background: { type: 'solid', color: 'white' },
                },
            };

            const chartLine = LightweightCharts.createChart(
                document.getElementById('container-line'), chartOptionsLine,
            );

            const areaSeries = chartLine.addAreaSeries(
                { lineColor: '#2962ff', topColor: '#2962ff', bottomColor: 'rgba(41, 98, 255, 0.28)' },
            );

            areaSeries.setData(data.line);
            chartLine.timeScale().fitContent();
        });
});


