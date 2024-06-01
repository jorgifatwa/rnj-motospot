define([
    "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "jqvalidate",
    "select2",
    "toastr"
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    jqvalidate,
    select2,
    toastr
    ) {
    return {
        table:null,
        init: function () {
            App.initFunc();
            App.initTable();
            App.initValidation();
            App.initConfirm();
            App.initEvent();
            $(".loadingpage").hide();
        },
        initEvent : function(){
            $('#cabang_id').select2({
                width: "100%",
                placeholder: "Pilih Cabang",
            });
            $('#merk_id').select2({
                width: "100%",
                placeholder: "Pilih Merk",
            });
            $('#jenis_id').select2({
                width: "100%",
                placeholder: "Pilih Jenis",
            });
            $('#status').select2({
                width: "100%",
                placeholder: "Pilih Status",
            });
            $('#harga_modal').on('input', function () {
                // Membersihkan input dari karakter non-numerik, kecuali koma dan titik desimal
                var cleanInput = $(this).val().replace(/[^\d.,]/g, '');
            
                // Hapus tanda desimal jika lebih dari satu
                cleanInput = cleanInput.replace(/(\..*)\./g, '$1');
            
                // Ganti tanda titik dengan string kosong (untuk menghindari kesalahan dalam parsing)
                cleanInput = cleanInput.replace(/\./g, '');
            
                // Ubah koma menjadi titik jika digunakan sebagai pemisah desimal
                cleanInput = cleanInput.replace(/,/g, '.');
            
                // Parsing input jumlah uang menjadi angka desimal
                var jumlahUang = parseFloat(cleanInput);

                $(this).val(jumlahUang.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }));
            })

            $('#harga_open').on('input', function () {
                // Membersihkan input dari karakter non-numerik, kecuali koma dan titik desimal
                var cleanInput = $(this).val().replace(/[^\d.,]/g, '');
            
                // Hapus tanda desimal jika lebih dari satu
                cleanInput = cleanInput.replace(/(\..*)\./g, '$1');
            
                // Ganti tanda titik dengan string kosong (untuk menghindari kesalahan dalam parsing)
                cleanInput = cleanInput.replace(/\./g, '');
            
                // Ubah koma menjadi titik jika digunakan sebagai pemisah desimal
                cleanInput = cleanInput.replace(/,/g, '.');
            
                // Parsing input jumlah uang menjadi angka desimal
                var jumlahUang = parseFloat(cleanInput);
                
                $(this).val(jumlahUang.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }));
            })

            $('#harga_net').on('input', function () {
                // Membersihkan input dari karakter non-numerik, kecuali koma dan titik desimal
                var cleanInput = $(this).val().replace(/[^\d.,]/g, '');
            
                // Hapus tanda desimal jika lebih dari satu
                cleanInput = cleanInput.replace(/(\..*)\./g, '$1');
            
                // Ganti tanda titik dengan string kosong (untuk menghindari kesalahan dalam parsing)
                cleanInput = cleanInput.replace(/\./g, '');
            
                // Ubah koma menjadi titik jika digunakan sebagai pemisah desimal
                cleanInput = cleanInput.replace(/,/g, '.');
            
                // Parsing input jumlah uang menjadi angka desimal
                var jumlahUang = parseFloat(cleanInput);
                
                $(this).val(jumlahUang.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }));
            })

            $('#km').on('input', function () {
                // Membersihkan input dari karakter non-numerik, kecuali koma dan titik desimal
                var cleanInput = $(this).val().replace(/[^\d.,]/g, '');
            
                // Hapus tanda desimal jika lebih dari satu
                cleanInput = cleanInput.replace(/(\..*)\./g, '$1');
            
                // Ganti tanda titik dengan string kosong (untuk menghindari kesalahan dalam parsing)
                cleanInput = cleanInput.replace(/\./g, '');
            
                // Ubah koma menjadi titik jika digunakan sebagai pemisah desimal
                cleanInput = cleanInput.replace(/,/g, '.');
            
                // Parsing input jumlah uang menjadi angka desimal
                var jumlahUang = parseFloat(cleanInput);
                
                $(this).val(jumlahUang.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }));
            })

            $('#dari_harga').on('input', function () {
                // Membersihkan input dari karakter non-numerik, kecuali koma dan titik desimal
                var cleanInput = $(this).val().replace(/[^\d.,]/g, '');
            
                // Hapus tanda desimal jika lebih dari satu
                cleanInput = cleanInput.replace(/(\..*)\./g, '$1');
            
                // Ganti tanda titik dengan string kosong (untuk menghindari kesalahan dalam parsing)
                cleanInput = cleanInput.replace(/\./g, '');
            
                // Ubah koma menjadi titik jika digunakan sebagai pemisah desimal
                cleanInput = cleanInput.replace(/,/g, '.');
            
                // Parsing input jumlah uang menjadi angka desimal
                var jumlahUang = parseFloat(cleanInput);
                
                $(this).val(jumlahUang.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }));
            })

            $('#sampai_harga').on('input', function () {
                // Membersihkan input dari karakter non-numerik, kecuali koma dan titik desimal
                var cleanInput = $(this).val().replace(/[^\d.,]/g, '');
            
                // Hapus tanda desimal jika lebih dari satu
                cleanInput = cleanInput.replace(/(\..*)\./g, '$1');
            
                // Ganti tanda titik dengan string kosong (untuk menghindari kesalahan dalam parsing)
                cleanInput = cleanInput.replace(/\./g, '');
            
                // Ubah koma menjadi titik jika digunakan sebagai pemisah desimal
                cleanInput = cleanInput.replace(/,/g, '.');
            
                // Parsing input jumlah uang menjadi angka desimal
                var jumlahUang = parseFloat(cleanInput);
                
                $(this).val(jumlahUang.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }));
            })
        },
        initTable : function(){
            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Lihat _MENU_ data",
                    "zeroRecords": "Tidak ada data yang cocok ditemukan",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data di dalam tabel",
                    "infoFiltered": "(cari dari _MAX_ total catatan)",
                    "loadingRecords": "Loading...",
                    "processing": "Processing...",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Selanjutnya",
                        "previous":   "Sebelumnya"
                    },
                },
                "order": [[ 0, "asc" ]], //agar kolom id default di order secara desc
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": App.baseUrl+"motor/dataList",
                    "dataType": "json",
                    "type": "POST",
                    data: function(d) {
                        d.tanggal_publish_mulai = $('#tanggal_publish_mulai').val();
                        d.tanggal_publish_akhir = $('#tanggal_publish_akhir').val();
                        d.dari_harga = $('#dari_harga').val();
                        d.sampai_harga = $('#sampai_harga').val();
                        d.cabang_id = $('#cabang_id').val();
                        d.jenis_id = $('#jenis_id').val();
                        d.merk_id = $('#merk_id').val();
                        d.nik = $('#nik').val();
                        // Add other filters here if needed
                    }
                },
                "columns": [
                    { "data": "created_at" },
                    { "data": "merk_name" },
                    { "data": "jenis_name" },
                    { "data": "nik" },
                    { "data": "km" },
                    { "data": "pajak" },
                    { "data": "cabang_name" },
                    { "data": "harga_modal" },
                    { "data": "harga_open" },
                    { "data": "harga_net" },
                    { "data": "action" ,"orderable": false}
                ]
            });

            // $('#btn-cari').on('click', function() {
            //     var cabang_id = $("#cabang_id").val();
            //     var jenis_id = $("#jenis_id").val();
            //     var merk_id = $("#merk_id").val();
            //     var tanggal_publish_mulai = $("#tanggal_publish_mulai").val();
            //     var tanggal_publish_akhir = $("#tanggal_publish_akhir").val();
            //     var dari_harga = $("#dari_harga").val();
            //     var sampai_harga = $("#sampai_harga").val();
            //     var nik = $("#nik").val();
        
            //     console.log({
            //         cabang_id: cabang_id,
            //         jenis_id: jenis_id,
            //         merk_id: merk_id,
            //         tanggal_publish_mulai: tanggal_publish_mulai,
            //         tanggal_publish_akhir: tanggal_publish_akhir,
            //         dari_harga: dari_harga,
            //         sampai_harga: sampai_harga,
            //         nik: nik
            //     });
        
            //     App.table.draw();
            // }); 
            
            $('#btn-cari').on('click', function() {
                App.table.draw();
            });

            $('#btn-reset').on('click', function () {
                $("#cabang_id").val('').trigger('change'); 
                $("#merk_id").val('').trigger('change'); 
                $("#jenis_id").val('').trigger('change'); 
                $("#tanggal_publish_mulai").val('').trigger('change'); 
                $("#tanggal_publish_akhir").val('').trigger('change'); 
                $("#nik").val(''); 
                $("#dari_harga").val(''); 
                $("#sampai_harga").val(''); 

                App.table.search( '' ).columns().search( '' ).draw();
            })
        },
        initValidation : function(){
            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({
                    rules: {
                        name: {
                            required: true
                        },
                        harga_jual: {
                            required: true
                        },
                        harga_modal: {
                            required: true
                        },
                        status: {
                            required: true
                        },
                    },
                    messages: {
                        name: {
                            required: "Nama Harus Diisi"
                        },
                        harga_jual: {
                            required: "Harga Jual Harus Diisi"
                        },
                        harga_modal: {
                            required: "Harga Modal Harus Diisi"
                        },
                        status: {
                            required: "Status Harus Diisi"
                        },
                    },
                    debug:true,

                    errorPlacement: function(error, element) {
                        var name = element.attr('name');
                        var errorSelector = '.form-control-feedback[for="' + name + '"]';
                        var $element = $(errorSelector);
                        if ($element.length) {
                            $(errorSelector).html(error.html());
                        } else {
                            if ( element.prop( "type" ) === "select-one" ) {
                                error.appendTo(element.parent());
                            }else if ( element.prop( "type" ) === "select-multiple" ) {
                                error.appendTo(element.parent());
                            }else if ( element.prop( "type" ) === "checkbox" ) {
                                error.insertBefore( element.next( "label" ) );
                            }else if ( element.prop( "type" ) === "radio" ) {
                                error.insertBefore( element.parent().parent().parent());
                            }else if ( element.parent().attr('class') === "input-group" ) {
                                error.appendTo(element.parent().parent());
                            }else{
                                error.insertAfter(element);
                            }
                        }
                    },
                    submitHandler : function(form) {
                        form.submit();
                    }
                });
            }
        },
        initConfirm :function(){
            $('#table tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                console.log(url);
                App.confirm("Apakah anda yakin untuk mengubah ini?",function(){
                   $.ajax({
                      method: "GET",
                      url: url
                    }).done(function( msg ) {
                        var data = JSON.parse(msg);
                        if (data.status == false) {
                            toastr.error(data.msg);
                        } else {
                            toastr.success(data.msg);
                            App.table.ajax.reload(null, true);
                        }
                    });
                })
            });
        }
	}
});
