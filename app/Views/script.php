<script>
    $(document).ready(function() {

        var filterTanggal = localStorage.getItem('filterTanggal');
        if (filterTanggal) {
            const data = JSON.parse(filterTanggal);

            // Isi ulang field berdasarkan name
            $('input[name="tanggal_awal"]').val(data.tanggal_awal);
            $('input[name="tanggal_akhir"]').val(data.tanggal_akhir);
        }

        filterTanggal = JSON.parse(filterTanggal);

        var filterTahun = localStorage.getItem('filterTahun');
        if (filterTahun) {
            const data = JSON.parse(filterTahun);

            // Isi ulang field berdasarkan name
            $('#filtertahun').val(data.tahun)
        }

        filterTahun = JSON.parse(filterTahun);

        // Render grafik dengan nilai itu
        <?php if (is_array(session('selected_akses'))): ?>
            grafikPendapatan(filterTahun);
        <?php endif; ?>
        grafikPendapatanBulanan(filterTahun);
        grafikPemakaianBahan(filterTanggal);
        widgetData(filterTanggal);
        widgetClosing(filterTanggal);

        var series, title, categories;
        let chart4, chart5, chart8 = null;

        $('#filter-form').submit(function(e) {
            e.preventDefault();

            localStorage.removeItem('filterTahun')
            localStorage.removeItem('filterTanggal')

            var formData = $(this).serializeArray();
            const tanggal = {};
            const tahun = {};
            formData.forEach(item => {
                if (item.name == 'tahun') tahun[item.name] = item.value;
                if (item.name !== 'tahun') tanggal[item.name] = item.value;
            });

            // Simpan ke localStorage (harus diubah ke string)
            localStorage.setItem('filterTanggal', JSON.stringify(tanggal));
            localStorage.setItem('filterTahun', JSON.stringify(tahun));

            var filterTanggal = localStorage.getItem('filterTanggal');

            filterTanggal = JSON.parse(filterTanggal);

            var filterTahun = localStorage.getItem('filterTahun');

            filterTahun = JSON.parse(filterTahun);

            // Render grafik dengan nilai 
            <?php if (is_array(session('selected_akses'))): ?>
                grafikPendapatan(filterTahun);
            <?php endif; ?>
            grafikPendapatanBulanan(filterTahun);
            grafikPemakaianBahan(filterTanggal);
            widgetData(filterTanggal);
            widgetClosing(filterTanggal);
        })

        <?php if (is_array(session('selected_akses'))): ?>
            // grafik pendapatan
            function grafikPendapatan(filterTahun) {
                var series, title, categories;
                $('#chart4').html('<div class="text-center p-5"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                $.ajax({
                    url: '<?= base_url('dashboard/grafik-pendapatan'); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        filterTahun
                    },
                    success: function(response) {
                        if (response.status === 200) {

                            title = response.data.title;
                            series = response.data.data;
                            categories = response.data.periode;

                            var options = {
                                series: series,
                                chart: {
                                    foreColor: '#9ba7b2',
                                    type: 'area',
                                    height: 360
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        columnWidth: '50%',
                                        endingShape: 'rounded'
                                    },
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    show: true,
                                    width: 2,
                                },
                                title: {
                                    text: title,
                                    align: 'left',
                                    style: {
                                        fontSize: '14px',
                                        color: "#32393f"
                                    }
                                },
                                colors: ['#0d6efd', '#ffc107', '#28a745', '#dc3545', '#17a2b8', '#6c757d', '#343a40', '#f8f9fa'],
                                xaxis: {
                                    categories: categories,
                                },
                                yaxis: {
                                    show: true,
                                    labels: {
                                        formatter: (val) => (val / 1000000).toFixed(1) + 'Jt'
                                    }
                                },
                                fill: {
                                    opacity: 1,
                                },
                                tooltip: {
                                    y: {
                                        formatter: function(val) {
                                            return "Rp" + addCommas(val);
                                        }
                                    }
                                }
                            };
                            chart4 = new ApexCharts(document.querySelector("#chart4"), options);
                            $('#chart4').html('');
                            chart4.render();

                        } else {
                            console.error('Error fetching data:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                })
            }
        <?php endif; ?>

        // grafik pendapatan bulann
        function grafikPendapatanBulanan(filterTahun) {
            var series, title, categories;
            $('#chart5').html('<div class="text-center p-5"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            $.ajax({
                url: '<?= base_url('dashboard/grafik-bulanan'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    filterTahun
                },
                success: function(response) {
                    if (response.status === 200) {
                        $('#filtertahun').val(response.data.tahun)

                        title = response.data.title;
                        series = response.data.data;
                        categories = response.data.periode;
                        console.log(series);

                        var options = {
                            series: [{
                                name: 'RP',
                                data: series
                            }],
                            chart: {
                                foreColor: '#9ba7b2',
                                type: 'bar',
                                height: 330
                            },
                            dataLabels: {
                                enabled: false
                            },
                            title: {
                                text: title,
                                align: 'left',
                                style: {
                                    fontSize: '14px',
                                    color: "#32393f"
                                }
                            },
                            colors: ['#0d6efd'],
                            xaxis: {
                                categories: categories,
                            },
                            yaxis: {
                                show: true,
                                labels: {
                                    formatter: (val) => (val / 1000000).toFixed(1) + 'Jt'
                                }
                            },
                            fill: {
                                opacity: 1
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return "Rp" + addCommas(val);
                                    }
                                }
                            }
                        };
                        var chart5 = new ApexCharts(document.querySelector("#chart5"), options);
                        $('#chart5').html('');
                        chart5.render();

                    } else {
                        console.error('Error fetching data:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            })
        }

        // grafik material
        function grafikPemakaianBahan(filterTanggal) {
            var series, title, categories;
            $('#chart8').html('<div class="text-center p-5"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            $.ajax({
                url: '<?= base_url('dashboard/grafik-material'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    filterTanggal
                },
                success: function(response) {
                    if (response.status === 200) {

                        console.log(response.data.tanggal_awal);
                        title = response.data.title;
                        series = response.data.data;
                        categories = response.data.name;
                        console.log(series);

                        var options = {
                            series: series,
                            chart: {
                                foreColor: '#9ba7b2',
                                height: 340,
                                type: 'pie',
                            },
                            title: {
                                text: title,
                                align: 'left',
                                style: {
                                    fontSize: '14px',
                                    color: "#32393f"
                                }
                            },
                            colors: ["#0d6efd", "#ac15feff", "#a00e0eff"],
                            labels: categories,
                            responsive: [{
                                breakpoint: 480,
                                options: {
                                    chart: {
                                        height: 360
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };
                        var chart8 = new ApexCharts(document.querySelector("#chart8"), options);
                        $('#chart8').html('');
                        chart8.render();

                    } else {
                        console.error('Error fetching data:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            })
        }

        // widget data
        function widgetData(filterTanggal) {
            $.ajax({
                url: '<?= base_url('dashboard/widget-data'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    filterTanggal
                },
                success: function(response) {
                    if (response.status === 200) {
                        $('input[name="tanggal_awal"]').val(response.data.tanggal_awal);
                        $('input[name="tanggal_akhir"]').val(response.data.tanggal_akhir);

                        $.each(response.data, function(key, value) {
                            $('#' + key).text(value);
                        });
                    } else {
                        console.error('Error fetching data:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            })
        }

        // widget closing
        function widgetClosing(filterTanggal) {
            $.ajax({
                url: '<?= base_url('dashboard/widget-closing'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    filterTanggal
                },
                success: function(response) {
                    if (response.status === 200) {

                        $('#widget-closing').html(response.data.html);
                    } else {
                        console.error('Error fetching data:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            })
        }

        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            let rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }
    });
</script>