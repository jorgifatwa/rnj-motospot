define([
    "jQuery",
    "bootstrap",
    "datatables",
    "datatablesBootstrap",
    "jqvalidate",
    "toastr",
    "select2"
    ], function (
    $,
    bootstrap,
    datatables,
    datatablesBootstrap,
    jqvalidate,
    toastr,
    select2
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
            $('#status').select2({
                width: "100%",
                placeholder: "Pilih Merk",
            });
            $('#jenis_id').select2({
                width: "100%",
                placeholder: "Pilih Jenis",
            });

            $('.js-example-basic-single').select2({
                placeholder: 'Pilih Pelanggan atau masukkan data baru',
                allowClear: true,
                tags: true
            });

            // Menambahkan event listener untuk menangkap saat opsi baru dipilih
            $('#selectBox').on('select2:select', function (e) {
                var data = e.params.data;

                // Jika data yang dipilih adalah data baru (bukan yang ada dalam opsi)
                if (data.hasOwnProperty('id') && data.id === data.text) {
                    // Kirim data baru ke server untuk disimpan
                    console.log('baru', data.text)
                    console.log('baru id', data.id)
                    // $.post('save_data.php', { newData: data.text }, function(response) {
                    //     alert(response); // Tampilkan pesan balasan dari server
                    // });
                }
            });

            function sumSubTotals() {
                var total = 0;
                $('.sub_total').each(function() {
                    var cleanInput = $(this).val().replace(/[^\d.,]/g, '');
                    // Hapus tanda desimal jika lebih dari satu
                    cleanInput = cleanInput.replace(/(\..*)\./g, '$1');
                    // Ganti tanda titik dengan string kosong (untuk menghindari kesalahan dalam parsing)
                    cleanInput = cleanInput.replace(/\./g, '');
                    // Ubah koma menjadi titik jika digunakan sebagai pemisah desimal
                    cleanInput = cleanInput.replace(/,/g, '.');
                    var value = parseFloat(cleanInput);
                    if (!isNaN(value)) {
                        total += value;
                    }
                });
                console.log('masuk total', total)
                $('#total_pembayaran').val('Rp ' + total.toLocaleString('id-ID'));
                $('.total_struk').text('Rp ' + total.toLocaleString('id-ID'));
                return total;
            }
        
            $(document).on('input', '.sub_total', function() {
                console.log('on sub total')
                var index = $(this).data('index');
                var cleanInput = $(this).val().replace(/[^\d.,]/g, '');
                // Hapus tanda desimal jika lebih dari satu
                cleanInput = cleanInput.replace(/(\..*)\./g, '$1');
                // Ganti tanda titik dengan string kosong (untuk menghindari kesalahan dalam parsing)
                cleanInput = cleanInput.replace(/\./g, '');
                // Ubah koma menjadi titik jika digunakan sebagai pemisah desimal
                cleanInput = cleanInput.replace(/,/g, '.');
                var value = parseFloat(cleanInput);
                
                $(this).val(value.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }));

                if (!isNaN(value)) {
                    $('#sub_total_struk_' + index).text('Rp ' + value.toLocaleString('id-ID'));
                }
                sumSubTotals();
            });

            function formatIDR(number) {
                var formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
                // Remove trailing ",00" if present
                return formatted.replace(",00", "");
            }
            
            $('#search-input').on('input', function() {
                var searchText = $(this).val().toLowerCase();
                $('.card').each(function() {
                    var productName = $(this).find('.card-title').text().toLowerCase();
                    if (productName.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            $(document).on('click', '.add-to-cart', function (e) {
                e.preventDefault();
                console.log('clicked')
                var productId = $(this).data('id');
                var productJenis = $(this).data('jenis');
                var productMerk = $(this).data('merk');
                var productPrice = $(this).data('price');

                addToCart(productId, productJenis, productPrice, productJenis, productMerk)
            })

            function handleAddToCart() {
                $('#data-produk').off('click', '.add-to-cart'); // Unbind existing event handlers
                $('#data-produk').on('click', '.add-to-cart', function(e) {
                    e.preventDefault();
                    var productId = $(this).data('id');
                    var productJenis = $(this).data('jenis');
                    var productMerk = $(this).data('merk');
                    var productPrice = $(this).data('price');

                    addToCart(productId, productJenis, productPrice, productJenis, productMerk)
                });
            }

            $('#search-form').on('submit', function(e){
                e.preventDefault(); // Prevent form from submitting normally
                
                var formData = $(this).serialize(); // Serialize form data

                
                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    success: function(data) {
                        var data = JSON.parse(data);
                        $('.pagination-data').html(data.links);
                        var html = "";
                        data = data.data_produks;
                        for (let index = 0; index < data.length; index++) {
                            html += `<div class="col-md-4">
                                        <div class="card" style="width: 18rem; height: 28rem;">
                                            <img src="${App.baseUrl}uploads/produk/${data[index].gambar}" class="card-img-top" alt="${data[index].nama}">
                                            <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                <h5 class="card-title">${data[index].nama}</h5>
                                                <p class="card-text text-secondary">${data[index].keterangan}</p>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-4">
                                                <p>${formatIDR(data[index].harga_jual)}</p>
                                                </div>
                                                <div class="col-md-8 text-right">
                                                <a href="#" class="btn btn-primary add-to-cart" data-id="${data[index].id}" data-name="${data[index].nama}" data-price="${data[index].harga_jual}" data-image="${data[index].gambar}">Tambah</a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>`;
                        } 
                        $('#data-produk').html(html);
                        handleAddToCart();
                    }
                });
                
            });

            $(document).on("change", ".quantity", function() {
                updateCart();
            });

            // Event listener for remove from cart button
            $(document).on("click", ".btn-remove", function() {
                var productId = $(this).data("id");
                removeFromCart(productId);
            });

            // Event listener for clear cart button
            $("#clear-cart").click(function() {
                clearCart();
            });

            // Function to add product to cart
            function  addToCart(productId, productJenis, productPrice, productJenis, productMerk)
            {
                var existingItem = $("#cart-items tr[data-id='" + productId + "']");
                if (existingItem.length > 0) {
                    // If item exists, increment quantity
                    var quantityInput = existingItem.find(".quantity");
                    var quantity = parseInt(quantityInput.val());
                    quantityInput.val(quantity + 1);
                } else {
                    // If item does not exist, add new item to cart
                    var formattedPrice = formatIDR(productPrice); // Format price to IDR currency format
                    var cartItemHtml = "<tr class='cart-item' data-id='" + productId + "'>" +
                                            "<td class='name'><input type='hidden' name='id_produk[]' value='"+productId+"'><input type='hidden' name='nama[]' value='"+productMerk+"-"+productJenis+"'>" +productMerk+"-"+productJenis+ "</td>" +
                                            "<td class='price'>" + formattedPrice + "</td>" +
                                            "<td><input type='number' class='form-control quantity' name='quantity[]' value='1' min='1'></td>" +
                                            "<td><button class='btn btn-sm btn-danger btn-remove' data-id='" + productId + "'>Remove</button></td>" +
                                        "</tr>";

                    $("#cart-items").append(cartItemHtml);
                }

                // Update subtotal and total
                updateCart();
            }


            // Function to update cart subtotal and total
            function updateCart() {
                var subtotal = 0;
                $("#cart-items tr").each(function() {
                    var price = parseFloat($(this).find(".price").text().replace("Rp", "").replace(/\./g, "").replace(",", "."));
                    var quantity = 1
                    subtotal += price * quantity;
                });

                var formattedSubtotal = formatIDR(subtotal);
                $("#subtotal").text(formattedSubtotal);

                // For now, total is the same as subtotal
                $("#total").text(formattedSubtotal);
            }


            // Function to remove product from cart
            function removeFromCart(productId) {
                $("#cart-items tr[data-id='" + productId + "']").remove();

                updateCart();
            }

            // Function to clear the cart
            function clearCart() {
                $("#cart-items").empty();

                updateCart();
            }
            
            // $(document).on('click', '.page-item a', function(e) {
            //     e.preventDefault();
            //     var page = $(this).attr('href').split('?page=')[1]; // Extract page number from data attribute
            //     $.ajax({
            //     url: 'Pesanan/pagination?page=' + page,
            //     type: 'GET',
            //     success: function(data) {
            //         var data = JSON.parse(data);
            //         $('.pagination-data').html(data.links);
            //         var html = "";
            //         data = data.data_produks;
            //         for (let index = 0; index < data.length; index++) {
            //             html += `<div class="col-md-4">
            //                         <div class="card" style="width: 18rem; height: 28rem;">
            //                             <img src="${App.baseUrl}uploads/produk/${data[index].gambar}" class="card-img-top" alt="${data[index].nama}">
            //                             <div class="card-body">
            //                             <div class="row">
            //                                 <div class="col-md-12">
            //                                 <h5 class="card-title">${data[index].nama}</h5>
            //                                 <p class="card-text text-secondary">${data[index].keterangan}</p>
            //                                 </div>
            //                             </div>
            //                             </div>
            //                             <div class="card-footer">
            //                             <div class="row">
            //                                 <div class="col-md-4">
            //                                 <p>${formatIDR(data[index].harga)}</p>
            //                                 </div>
            //                                 <div class="col-md-8 text-right">
            //                                 <a href="#" class="btn btn-primary add-to-cart" data-id="${data[index].id}" data-name="${data[index].nama}" data-price="${data[index].harga_jual}" data-image="${data[index].gambar}">Tambah</a>
            //                                 </div>
            //                             </div>
            //                             </div>
            //                         </div>
            //                         </div>`;
            //         } 
            //         $('#data-produk').html(html);
            //         handleAddToCart();
            //     }
            //     });
            // }); 

            $('input[name="metode_pembayaran"]').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue === "cash") {
                    $('.tunai').removeClass('d-none');
                    $('.non_tunai').addClass('d-none');
                } else if (selectedValue === "qris") {
                    $('.tunai').addClass('d-none');
                    $('.non_tunai').removeClass('d-none');
                }else if(selectedValue === "booking"){
                    $('.tunai').addClass('d-none');
                    $('.non_tunai').addClass('d-none');
                    $("#status").val(2).trigger('change'); 
                    $(".status-form").addClass('d-none');
                }
            });

            $('#jumlah_uang').on('input', function() {
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
            
                // Set nilai input dengan angka yang sudah diparsing
                $(this).val(jumlahUang.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }));
            
                // Lakukan perhitungan kembalian
                var totalPembayaran = parseFloat($('#total_pembayaran').val().replace(/[^\d]/g, ''));
                var kembalian = jumlahUang - totalPembayaran;

                // Tampilkan kembalian
                if (kembalian < 0) {
                    $('.error-jumlah').removeClass('d-none');
                    $('.btn-simpan').attr('disabled', '');
                    $('#kembalian').val('Rp 0');
                }else if(cleanInput == "") {
                    $('.btn-simpan').attr('disabled', '');
                    $('#kembalian').val('Rp 0');
                    $('#jumlah_uang').val('0');
                }else {
                    $('#kembalian').val('Rp ' + kembalian.toLocaleString('id-ID', {
                        maximumFractionDigits: 0
                    }));
                    $('.btn-simpan').removeAttr('disabled');
                    $('.error-jumlah').addClass('d-none');
                }
            });

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
            $('.sub_total').each(function() {
                var cleanInput = $(this).val().replace(/[^\d.,]/g, '');
                // Hapus tanda desimal jika lebih dari satu
                cleanInput = cleanInput.replace(/(\..*)\./g, '$1');
                // Ganti tanda titik dengan string kosong (untuk menghindari kesalahan dalam parsing)
                cleanInput = cleanInput.replace(/\./g, '');
                // Ubah koma menjadi titik jika digunakan sebagai pemisah desimal
                cleanInput = cleanInput.replace(/,/g, '.');
                var value = parseFloat(cleanInput);
                $(this).val(value.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }));
            });
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
                        d.pesanan = true;
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
                    { "data": "nopol" },
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
                        metode_pembayaran: {
                            required: true
                        },
                    },
                    messages: {
                        metode_pembayaran: {
                            required: "Metode Pembayaran Harus Diddisi"
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
                                error.insertBefore( element.parent().parent().parent().parent());
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

            if($("#form_checkout").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form_checkout").validate({
                    rules: {
                        metode_pembayaran: {
                            required: true
                        },
                        jumlah_uang: {
                            required: function(element) {
                                // Ambil nilai metode_pembayaran
                                var metode_pembayaran = $("#metode_pembayaran").val();
                                // Jumlah uang wajib diisi jika metode pembayaran adalah "cash"
                                return metode_pembayaran === "cash";
                            }
                        },
                        status: {
                            required: true
                        }
                    },
                    messages: {
                        metode_pembayaran: {
                            required: "Metode Pembayaran Harus Diisi"
                        },
                        jumlah_uang: {
                            required: "Jumlah Uang Harus Diisi"
                        },
                        status: {
                            required: true
                        }
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
                                error.appendTo(element.parent().parent().parent().parent().find('.error-radio'));
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
