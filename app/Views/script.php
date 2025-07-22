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

        // Render grafik dengan nilai itu
        <?php if (is_array(session('selected_akses'))): ?>
            grafikPendapatan();
        <?php endif; ?>
        grafikPendapatanBulanan();
        grafikPemakaianBahan(filterTanggal);
        widgetData(filterTanggal);
        widgetClosing(filterTanggal);

        var series, title, categories;
        let chart4, chart5, chart8 = null;

        $('#filter-form').submit(function(e) {
            e.preventDefault();

            localStorage.removeItem('filterTanggal')

            var formData = $(this).serializeArray();
            const data = {};
            formData.forEach(item => {
                data[item.name] = item.value;
            });

            // Simpan ke localStorage (harus diubah ke string)
            localStorage.setItem('filterTanggal', JSON.stringify(data));

            var filterTanggal = localStorage.getItem('filterTanggal');

            filterTanggal = JSON.parse(filterTanggal);

            // Render grafik dengan nilai 
            grafikPemakaianBahan(filterTanggal);
            widgetData(filterTanggal);
            widgetClosing(filterTanggal);
        })

        <?php if (is_array(session('selected_akses'))): ?>
            // grafik pendapatan
            function grafikPendapatan() {
                var series, title, categories;
                $('#chart4').html('<div class="text-center p-5"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                $.ajax({
                    url: '<?= base_url('dashboard/grafik-pendapatan'); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 200) {
                            // Hapus chart sebelumnya jika sudah ada
                            // if (chart4 !== null) chart4.destroy();

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
        function grafikPendapatanBulanan() {
            var series, title, categories;
            $('#chart5').html('<div class="text-center p-5"><div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            $.ajax({
                url: '<?= base_url('dashboard/grafik-bulanan'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        // Hapus chart sebelumnya jika sudah ada
                        // if (chart5 !== null) chart5.destroy();

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
                        // Hapus chart sebelumnya jika sudah ada
                        // if (chart5 !== null) chart5.destroy();

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