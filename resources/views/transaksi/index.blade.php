@extends('layout.main')

@section('title', 'Transaksi Penjualan')
@section('page-title', 'Transaksi Penjualan')

@section('main-content')
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-shopping-bag me-2"></i>Pilih Barang</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-5 position-relative">
                        <label class="form-label fw-medium">Pilih Barang</label>
                        <input type="text" id="searchBarang" class="form-control" placeholder="Ketik nama atau kode barang..." autocomplete="off">
                        <input type="hidden" id="barangId" value="">
                        <div id="barangResults" class="list-group mt-2" style="display:none; max-height:200px; overflow-y:auto; position:absolute; z-index:1000; width:100%;"></div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="text" id="hargaBarang" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Jumlah</label>
                        <input type="number" id="jumlahBarang" class="form-control" min="1" value="1">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">&nbsp;</label>
                        <span class="input-group-text bg-light" id="satuanBarang">pcs</span>
                    </div>
                </div>
                <button type="button" class="btn btn-primary w-100 fw-medium" onclick="tambahKeranjang()">
                    <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                 </button>
             </div>
         </div>
         
         <div class="card mt-4 border-danger">
             <div class="card-header bg-danger text-white">
                 <h5 class="mb-0 fw-bold"><i class="fas fa-hand-holding-usd me-2"></i>Bayar Hutang</h5>
             </div>
             <div class="card-body">
                 <div class="mb-3 position-relative">
                      <label class="form-label fw-medium">Cari Pelanggan (No. Member / Nama / No. HP)</label>
                      <input type="text" id="searchPiutang" class="form-control" placeholder="Ketik no member, nama, atau nomor HP pelanggan...">
                     <div id="searchResults" class="list-group mt-2" style="display:none; max-height:200px; overflow-y:auto; position:absolute; z-index:1000; width:100%;"></div>
                 </div>
                 
                  <div id="debtSection" style="display:none;">
                      <input type="hidden" id="debtNoMember" value="">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                          <h6 class="fw-bold">
                              Hutang: <span id="debtCustomerName" class="text-primary"></span>
                              <span id="debtMemberNo" class="fw-normal text-muted ms-2"></span>
                          </h6>
                         <div class="form-check">
                             <input class="form-check-input" type="checkbox" id="selectAllDebts">
                             <label class="form-check-label" for="selectAllDebts">Pilih Semua</label>
                         </div>
                     </div>
                     <div id="debtList" class="list-group mb-3" style="max-height:250px; overflow-y:auto;"></div>
                     <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-3">
                         <span class="fw-medium">Total Dipilih:</span>
                         <span class="fw-bold text-danger fs-5" id="selectedDebtTotal">Rp 0</span>
                     </div>
                     <button type="button" class="btn btn-danger w-100 fw-medium py-2" onclick="tambahPiutangKeKeranjang()">
                         <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                     </button>
                 </div>
             </div>
         </div>
         
         <div class="card mt-4">
             <div class="card-header bg-white d-flex justify-content-between align-items-center">
                 <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-history me-2"></i>Riwayat Transaksi</h5>
                 <input type="date" id="filterTanggal" class="form-control" value="{{ date('Y-m-d') }}" style="width: 160px;">
             </div>
             <div class="card-body p-0">
                 <div class="table-responsive">
                     <table class="table table-hover mb-0">
                         <thead>
                              <tr>
                                  <th class="text-center">No</th>
                                  <th>Kode Transaksi</th>
                                  <th>Waktu</th>
                                  <th>Keterangan</th>
                                  <th class="text-end">Total</th>
                                  <th>Kasir</th>
                                  <th class="text-center">Aksi</th>
                              </tr>
                         </thead>
                         <tbody id="transaksiBody">
                              @foreach($transaksis as $index => $transaksi)
                              <tr>
                                  <td class="text-center">{{ $index + 1 }}</td>
                                  <td class="fw-bold text-primary">{{ $transaksi->kode_transaksi }}</td>
                                  <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->setTimezone('Asia/Makassar')->format('H:i') }}</td>
                                  <td>
                                      @if($transaksi->piutangs->contains('status', 'belum_lunas'))
                                          @php
                                              $piutang = $transaksi->piutangs->firstWhere('status', 'belum_lunas');
                                          @endphp
                                          <span class="badge bg-warning">Hutang</span>
                                          <small class="d-block text-muted mt-1">{{ $piutang->nama_pelanggan }} - {{ $piutang->no_hp }}</small>
                                       @elseif($transaksi->piutangs->contains('status', 'lunas'))
                                           @php
                                               $piutang = $transaksi->piutangs->firstWhere('status', 'lunas');
                                           @endphp
                                           <span class="badge bg-success">Bayar Hutang</span>
                                           <small class="d-block text-muted mt-1">{{ $piutang->nama_pelanggan }} - {{ $piutang->no_hp }}</small>
                                      @else
                                          <span class="badge bg-primary">Bayar</span>
                                      @endif
                                  </td>
                                  <td class="text-end fw-bold">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                  <td>{{ $transaksi->user->name ?? '-' }}</td>
                                   <td class="text-center">
                                      <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-sm btn-outline-primary">
                                          <i class="fas fa-eye"></i>
                                      </a>
                                      @if($transaksi->piutangs->contains('status', 'belum_lunas'))
                                      <button class="btn btn-sm btn-outline-danger ms-1" onclick="loadPiutangForTransaksi({{ $transaksi->piutangs->firstWhere('status', 'belum_lunas')->id }})">
                                          <i class="fas fa-money-bill-wave"></i>
                                      </button>
                                      @endif
                                  </td>
                             </tr>
                             @endforeach
                         </tbody>
                         @if($transaksis->count() > 0)
                         <tfoot>
                              <tr class="table-light">
                                  <th colspan="4" class="text-end">Total Hari Ini:</th>
                                  <th class="text-end fw-bold text-primary">Rp {{ number_format($transaksis->sum('total'), 0, ',', '.') }}</th>
                                  <th colspan="2"></th>
                              </tr>
                         </tfoot>
                         @endif
                     </table>
                 </div>
             </div>
         </div>
     </div>
     
     <div class="col-lg-4">
         <div class="sticky-sidebar" style="position: sticky; top: 90px; z-index: 10;">
             <div class="card mb-4">
                 <div class="card-header bg-white">
                     <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-shopping-cart me-2"></i>Keranjang</h5>
                 </div>
                 <div class="card-body">
                     <div id="keranjang-container" style="max-height: 200px; overflow-y: auto;">
                         <div class="text-center text-muted py-4">
                             <i class="fas fa-shopping-basket fa-2x mb-2"></i>
                             <p class="mb-0">Keranjang kosong</p>
                         </div>
                     </div>
                     
                     <hr>
                     
                     <div class="d-flex justify-content-between mb-2">
                         <span class="text-muted">Total Item:</span>
                         <span class="fw-bold" id="totalItem">0</span>
                     </div>
                     <div class="d-flex justify-content-between mb-4">
                         <span class="fw-medium">Total:</span>
                         <span class="fw-bold text-primary" style="font-size: 20px;" id="totalKeranjang">Rp 0</span>
                     </div>
                     
                     <div class="d-grid gap-2">
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="tipePembayaran" id="bayarLangsung" value="bayar" checked>
                             <label class="form-check-label" for="bayarLangsung">
                                 <i class="fas fa-money-bill-wave me-1"></i> Bayar Sekarang
                             </label>
                         </div>
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="tipePembayaran" id="bayarHutang" value="hutang">
                             <label class="form-check-label" for="bayarHutang">
                                 <i class="fas fa-hand-holding-usd me-1"></i> Hutang / Piutang
                             </label>
                         </div>
                     </div>

                      <div id="hutangFields" class="mt-3" style="display: none;">
                          <input type="hidden" id="noMember" value="">

                          <div class="mb-3">
                              <label class="form-label fw-medium">Status Pelanggan</label>
                              <div class="d-flex gap-3">
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="memberStatus" id="memberBaru" value="baru" checked>
                                      <label class="form-check-label" for="memberBaru">Belum punya No. Member</label>
                                  </div>
                                  <div class="form-check">
                                      <input class="form-check-input" type="radio" name="memberStatus" id="memberLama" value="lama">
                                      <label class="form-check-label" for="memberLama">Sudah punya No. Member</label>
                                  </div>
                              </div>
                          </div>

                          <div id="memberSearchBox" class="mb-3 position-relative" style="display: none;">
                              <label class="form-label fw-medium">Cari Pelanggan (No. Member / Nama / No. HP)</label>
                              <input type="text" id="searchMember" class="form-control" placeholder="Ketik nama, no member, atau nomor HP..." autocomplete="off">
                              <div id="memberResults" class="list-group mt-2" style="display:none; max-height:200px; overflow-y:auto; position:absolute; z-index:1000; width:100%;"></div>
                          </div>

                          <div id="memberForm" class="row g-3">
                              <div class="col-md-6">
                                  <label class="form-label fw-medium">Nama Pelanggan</label>
                                  <input type="text" id="namaPelanggan" class="form-control" placeholder="Masukkan nama pelanggan">
                              </div>
                              <div class="col-md-6">
                                  <label class="form-label fw-medium">No. HP Pelanggan</label>
                                  <input type="text" id="noHpPelanggan" class="form-control" placeholder="Masukkan nomor HP">
                              </div>
                          </div>

                          <div class="mt-2">
                              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetMemberSelection()" id="resetMemberBtn" style="display: none;">
                                  <i class="fas fa-eraser me-1"></i>Batal Pilih Pelanggan
                              </button>
                          </div>
                      </div>

                     <div class="d-grid gap-2 mt-3">
                         <button type="button" class="btn btn-success fw-medium py-3" onclick="simpanTransaksi()">
                             <i class="fas fa-check-circle me-2"></i>Simpan Transaksi
                         </button>
                         <button type="button" class="btn btn-outline-secondary fw-medium" onclick="kosongkanKeranjang()">
                             <i class="fas fa-trash me-2"></i>Kosongkan
                         </button>
                     </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="printPreviewModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="mb-0 fw-bold"><i class="fas fa-print me-2"></i>Preview Nota Transaksi</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
              </div>
              <div class="modal-body p-0">
                  <iframe id="previewIframe" src="" width="100%" frameborder="0" style="height: 60vh;"></iframe>
              </div>
              <div class="modal-footer justify-content-center gap-2">
                  <button type="button" class="btn btn-primary" onclick="cetakNota()">
                      <i class="fas fa-print me-1"></i> Cetak
                  </button>
                  <a href="#" id="lihatBtn" target="_blank" class="btn btn-outline-primary">
                      <i class="fas fa-eye me-1"></i> Lihat
                  </a>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                      <i class="fas fa-check me-1"></i> Selesai
                  </button>
              </div>
          </div>
      </div>
  </div>
  @endsection

 @section('scripts')
 <script>
      let keranjang = [];
      let selectedBarang = null;
      let searchResults = [];

      let selectedPiutangs = [];

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      let searchTimeout = null;

      function loadBarangResults(query) {
          clearTimeout(searchTimeout);
          searchTimeout = setTimeout(() => {
              $.ajax({
                  url: '{{ route("transaksi.barang.search") }}',
                  method: 'GET',
                  data: { q: query },
                  success: function(data) {
                      searchResults = data;
                      if (data.length === 0) {
                          $('#barangResults').html('<div class="list-group-item text-muted">Tidak ditemukan</div>').show();
                          return;
                      }

                      let html = '';
                      data.forEach((barang, i) => {
                          html += `<div class="list-group-item list-group-item-action cursor-pointer" data-index="${i}">
                              <div class="d-flex justify-content-between">
                                  <div>
                                      <strong>${barang.nama_barang}</strong><br>
                                      <small class="text-muted">${barang.kode_barang} - Stok: ${barang.stok}</small>
                                  </div>
                                  <div class="text-end">
                                      <span class="fw-bold">Rp ${parseInt(barang.harga).toLocaleString('id-ID')}</span>
                                  </div>
                              </div>
                          </div>`;
                      });
                      $('#barangResults').html(html).show();
                  }
              });
          }, 300);
      }

      $('#searchBarang').on('input', function() {
          loadBarangResults($(this).val().trim());
      });

      $('#searchBarang').on('focus', function() {
          if ($(this).val().trim().length === 0) {
              loadBarangResults('');
          }
      });

      function selectBarang(barang) {
          selectedBarang = barang;
          $('#barangId').val(barang.id);
          $('#searchBarang').val(`${barang.kode_barang} - ${barang.nama_barang}`);
          $('#hargaBarang').val(barang.harga ? parseInt(barang.harga).toLocaleString('id-ID') : '0');
          $('#satuanBarang').text(barang.satuan || 'pcs');
          $('#jumlahBarang').attr('max', barang.stok);
          $('#jumlahBarang').val(1);
          $('#barangResults').hide();
      }

      $(document).on('click', '#barangResults .list-group-item', function() {
          const idx = parseInt($(this).data('index'));
          if (!isNaN(idx) && searchResults[idx]) {
              selectBarang(searchResults[idx]);
          }
      });

      function tambahKeranjang() {
          const barangId = $('#barangId').val();
          const jumlah = parseInt($('#jumlahBarang').val());
          
          if (!barangId) {
              Swal.fire({ icon: 'warning', title: 'Pilih barang terlebih dahulu' });
              return;
          }
          
          if (jumlah < 1) {
              Swal.fire({ icon: 'warning', title: 'Jumlah minimal 1' });
              return;
          }

          const barang = selectedBarang;
          if (jumlah > barang.stok) {
              Swal.fire({ icon: 'warning', title: 'Stok tidak mencukupi', text: 'Stok tersedia: ' + barang.stok });
              return;
          }

          const existingIndex = keranjang.findIndex(k => k.type === 'barang' && k.barang_id == barangId);
         if (existingIndex >= 0) {
             const newQty = keranjang[existingIndex].qty + jumlah;
             if (newQty > barang.stok) {
                 Swal.fire({ icon: 'warning', title: 'Stok tidak mencukupi' });
                 return;
             }
             keranjang[existingIndex].qty = newQty;
             keranjang[existingIndex].subtotal = newQty * barang.harga;
         } else {
             keranjang.push({
                 type: 'barang',
                 barang_id: barangId,
                 kode_barang: barang.kode_barang,
                 nama_barang: barang.nama_barang,
                 harga: barang.harga,
                 qty: jumlah,
                 subtotal: jumlah * barang.harga,
                 satuan: barang.satuan || 'pcs'
             });
         }

          renderKeranjang();
          $('#searchBarang').val('');
          $('#barangId').val('');
          selectedBarang = null;
          $('#hargaBarang').val('');
          $('#jumlahBarang').val(1);
      }

     function renderKeranjang() {
         const container = document.getElementById('keranjang-container');
         if (keranjang.length === 0) {
             container.innerHTML = '<div class="text-center text-muted py-4"><i class="fas fa-shopping-basket fa-2x mb-2"></i><p class="mb-0">Keranjang kosong</p></div>';
             document.getElementById('totalKeranjang').textContent = 'Rp 0';
             document.getElementById('totalItem').textContent = '0';
             return;
         }

         let html = '<table class="table table-sm mb-0">';
         let total = 0;
         let totalItem = 0;
         
         keranjang.forEach((item, index) => {
             total += item.subtotal;
             if (item.type === 'barang') {
                 totalItem += item.qty;
                 html += `<tr>
                     <td class="py-2">
                         <div class="fw-medium">${item.nama_barang}</div>
                         <small class="text-muted">${item.harga.toLocaleString('id-ID')} x ${item.qty}</small>
                     </td>
                     <td class="text-end py-2 fw-bold">${item.subtotal.toLocaleString('id-ID')}</td>
                     <td class="text-center py-2">
                         <button class="btn btn-sm btn-outline-danger" onclick="hapusKeranjang(${index})"><i class="fas fa-times"></i></button>
                     </td>
                 </tr>`;
             } else if (item.type === 'piutang') {
                 html += `<tr>
                     <td class="py-2">
                         <div class="fw-medium text-danger"><i class="fas fa-hand-holding-usd me-1"></i>Bayar Hutang - ${item.nama_pelanggan}</div>
                         <small class="text-muted">${item.piutang_ids.length} hutang dipilih</small>
                     </td>
                     <td class="text-end py-2 fw-bold text-danger">${item.subtotal.toLocaleString('id-ID')}</td>
                     <td class="text-center py-2">
                         <button class="btn btn-sm btn-outline-danger" onclick="hapusKeranjang(${index})"><i class="fas fa-times"></i></button>
                     </td>
                 </tr>`;
             }
         });
         
         html += '</table>';
         container.innerHTML = html;
         document.getElementById('totalKeranjang').textContent = 'Rp ' + total.toLocaleString('id-ID');
         document.getElementById('totalItem').textContent = totalItem;
     }

     function hapusKeranjang(index) {
         keranjang.splice(index, 1);
         renderKeranjang();
     }

     function kosongkanKeranjang() {
         if (keranjang.length === 0) return;
         
         Swal.fire({
             title: 'Kosongkan Keranjang?',
             text: 'Semua item akan dihapus',
             icon: 'question',
             showCancelButton: true,
             confirmButtonText: 'Ya, Kosongkan',
             cancelButtonText: 'Batal'
         }).then((result) => {
             if (result.isConfirmed) {
                 keranjang = [];
                 renderKeranjang();
             }
         });
     }

     function simpanTransaksi() {
         const barangItems = keranjang.filter(k => k.type === 'barang');
         const piutangItems = keranjang.filter(k => k.type === 'piutang');

         if (barangItems.length === 0 && piutangItems.length === 0) {
             Swal.fire({ icon: 'warning', title: 'Keranjang masih kosong' });
             return;
         }

          const isHutang = $('#bayarHutang').is(':checked');
          const namaPelanggan = $('#namaPelanggan').val();
          const noHp = $('#noHpPelanggan').val();
          const noMember = $('#noMember').val();
          const memberLama = $('#memberLama').is(':checked');

          if (isHutang && barangItems.length > 0 && (!namaPelanggan || !noHp)) {
              Swal.fire({ icon: 'warning', title: 'Data Pelanggan Diperlukan', text: 'Masukkan nama dan nomor HP pelanggan untuk transaksi hutang' });
              return;
          }

          if (isHutang && barangItems.length > 0 && memberLama && !noMember) {
              Swal.fire({ icon: 'warning', title: 'Pilih Pelanggan', text: 'Cari dan pilih pelanggan yang sudah memiliki No. Member' });
              return;
          }

         Swal.fire({
             title: 'Simpan Transaksi?',
             text: 'Total: ' + $('#totalKeranjang').text() + (piutangItems.length > 0 ? ' (Termasuk Bayar Hutang)' : (isHutang ? ' (Hutang)' : '')),
             icon: 'question',
             showCancelButton: true,
             confirmButtonText: 'Simpan',
             cancelButtonText: 'Batal'
         }).then((result) => {
             if (result.isConfirmed) {
                 const requestData = {
                     _token: '{{ csrf_token() }}',
                     items: barangItems,
                     piutang_items: piutangItems.map(p => ({
                         piutang_ids: p.piutang_ids,
                         total: p.subtotal
                     })),
                      tipe_pembayaran: isHutang ? 'hutang' : 'bayar',
                      no_member: isHutang ? noMember : null,
                      nama_pelanggan: isHutang ? namaPelanggan : null,
                      no_hp: isHutang ? noHp : null
                 };

                 $.ajax({
                     url: '{{ route("transaksi.store") }}',
                     method: 'POST',
                     data: requestData,
                      success: function(response) {
                          Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 1200, showConfirmButton: false });
                          resetFormTransaksi();
                          const trxId = response.transaksi_id;
                          if (trxId) {
                              $('#previewIframe').attr('src', '{{ route('transaksi.cetak', '__ID__') }}'.replace('__ID__', trxId));
                              $('#lihatBtn').attr('href', '{{ route('transaksi.show', '__ID__') }}'.replace('__ID__', trxId));
                              $('#printPreviewModal').modal('show');
                          } else {
                              setTimeout(() => location.reload(), 1500);
                          }
                      },
                     error: function(xhr) {
                         Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON.message });
                     }
                 });
             }
         });
     }

      function resetFormTransaksi() {
          keranjang = [];
          selectedPiutangs = [];
          renderKeranjang();
          $('#hutangFields').slideUp();
          $('#bayarLangsung').prop('checked', true);
          $('#memberBaru').prop('checked', true);
          $('#memberSearchBox').hide();
          resetMemberSelection();
          $('#debtSection').hide();
          $('#searchPiutang').val('');
      }

      function cetakNota() {
          const iframe = document.getElementById('previewIframe');
          const win = iframe && iframe.contentWindow;
          if (win) {
              win.focus();
              win.print();
          }
      }

      $('#printPreviewModal').on('hidden.bs.modal', function () {
          const iframe = document.getElementById('previewIframe');
          if (iframe) {
              iframe.src = '';
          }
          location.reload();
      });

      $('#searchPiutang').on('input', function() {
         const query = $(this).val().trim();
         if (query.length < 1) {
             $('#searchResults').hide();
             return;
         }

         $.ajax({
             url: '{{ route("transaksi.piutang.search") }}',
             method: 'GET',
             data: { q: query },
             success: function(data) {
                 if (data.length === 0) {
                     $('#searchResults').html('<div class="list-group-item text-muted">Tidak ditemukan</div>').show();
                     return;
                 }

                  let html = '';
                  data.forEach(customer => {
                      const noMember = customer.no_member ? customer.no_member : '-';
                      html += `<div class="list-group-item list-group-item-action cursor-pointer" onclick="selectPiutangCustomer('${customer.nama_pelanggan.replace(/'/g, "\\'")}', '${customer.no_hp.replace(/'/g, "\\'")}', '${customer.no_member}')">
                          <div class="d-flex justify-content-between">
                              <div>
                                  <strong>${customer.nama_pelanggan}</strong><br>
                                  <small class="text-muted">No. Member: ${noMember} - ${customer.no_hp}</small>
                              </div>
                              <div class="text-end">
                                  <span class="badge bg-danger">Rp ${parseInt(customer.total_hutang).toLocaleString('id-ID')}</span>
                              </div>
                          </div>
                      </div>`;
                  });
                 $('#searchResults').html(html).show();
             }
         });
     });

      $(document).on('click', function(e) {
          if (!$(e.target).closest('#searchPiutang, #searchResults, #searchBarang, #barangResults, #searchMember, #memberResults').length) {
              $('#searchResults').hide();
              $('#barangResults').hide();
              $('#memberResults').hide();
          }
      });

        function selectPiutangCustomer(nama, noHp, noMember = '') {
            $('#searchPiutang').val(nama);
            $('#searchResults').hide();
            $('#debtCustomerName').text(nama);
            $('#debtNoMember').val(noMember);
            $('#debtMemberNo').text(noMember ? '(No. Member: ' + noMember + ')' : '');

            $.ajax({
                url: '{{ route("transaksi.piutang.search") }}',
                method: 'GET',
                data: { q: nama },
                success: function(data) {
                    let customer = data.find(c => c.nama_pelanggan === nama);
                    if (!customer && data.length > 0) {
                        customer = data[0];
                    }
                    if (!customer) {
                        Swal.fire({ icon: 'warning', title: 'Data hutang tidak ditemukan untuk: ' + nama });
                        return;
                    }

                    if (customer.no_member) {
                        $('#debtNoMember').val(customer.no_member);
                        $('#debtMemberNo').text('(No. Member: ' + customer.no_member + ')');
                    }

                    selectedPiutangs = customer.piutangs;
                    let html = '';
                  customer.piutangs.forEach((p, index) => {
                      const tanggal = p.tanggal ? new Date(p.tanggal).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '-';
                      html += `<div class="list-group-item">
                          <div class="form-check">
                              <input class="form-check-input piutang-check" type="checkbox" value="${p.id}" data-jumlah="${p.jumlah}" data-tanggal="${tanggal}" id="piutang_${p.id}" onchange="updateSelectedDebtTotal()">
                              <label class="form-check-label w-100" for="piutang_${p.id}">
                                  <div class="d-flex justify-content-between">
                                      <span>Hutang ${tanggal}</span>
                                      <span class="fw-bold text-danger">Rp ${parseInt(p.jumlah).toLocaleString('id-ID')}</span>
                                  </div>
                              </label>
                          </div>
                      </div>`;
                  });
                  $('#debtList').html(html);
                  $('#debtSection').show();
                  updateSelectedDebtTotal();
              }
          });
      }

     function updateSelectedDebtTotal() {
         let total = 0;
         $('.piutang-check:checked').each(function() {
             total += parseInt($(this).data('jumlah'));
         });
         $('#selectedDebtTotal').text('Rp ' + total.toLocaleString('id-ID'));
     }

     $('#selectAllDebts').on('change', function() {
         $('.piutang-check').prop('checked', this.checked);
         updateSelectedDebtTotal();
     });

      function tambahPiutangKeKeranjang() {
          const checkedBoxes = $('.piutang-check:checked');
          if (checkedBoxes.length === 0) {
              Swal.fire({ icon: 'warning', title: 'Pilih hutang yang akan dibayar' });
              return;
          }

          const piutangIds = checkedBoxes.map(function() { return parseInt($(this).val()); }).get();
          const total = checkedBoxes.map(function() { return parseInt($(this).data('jumlah')); }).get().reduce((a, b) => a + b, 0);
          const nama = $('#debtCustomerName').text();

          keranjang.push({
              type: 'piutang',
              piutang_ids: piutangIds,
              nama_pelanggan: nama,
              subtotal: total
          });

          renderKeranjang();

          Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Hutang ditambahkan ke keranjang', timer: 1500, showConfirmButton: false });

          $('#debtSection').hide();
          $('#searchPiutang').val('');
          $('#debtNoMember').val('');
          $('#debtMemberNo').text('');
          selectedPiutangs = [];
      }

      function loadPiutangForTransaksi(piutangId) {
          $.ajax({
              url: '{{ route("transaksi.piutang") }}',
              success: function(data) {
                  const piutang = data.find(p => p.id == piutangId);
                   if (piutang) {
                       $('#searchPiutang').val(piutang.nama_pelanggan);
                       $('#debtCustomerName').text(piutang.nama_pelanggan);
                       $('#debtNoMember').val(piutang.no_member || '');
                       $('#debtMemberNo').text(piutang.no_member ? '(No. Member: ' + piutang.no_member + ')' : '');
                      
                      const customerPiutangs = data.filter(p => p.nama_pelanggan === piutang.nama_pelanggan && p.status === 'belum_lunas');
                      selectedPiutangs = customerPiutangs;
                      
                      let html = '';
                      customerPiutangs.forEach((p) => {
                          const tanggal = p.tanggal ? new Date(p.tanggal).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }) : '-';
                          html += `<div class="list-group-item">
                              <div class="form-check">
                                  <input class="form-check-input piutang-check" type="checkbox" value="${p.id}" data-jumlah="${p.jumlah}" data-tanggal="${tanggal}" id="piutang_${p.id}" onchange="updateSelectedDebtTotal()">
                                  <label class="form-check-label w-100" for="piutang_${p.id}">
                                      <div class="d-flex justify-content-between">
                                          <span>Hutang ${tanggal}</span>
                                          <span class="fw-bold text-danger">Rp ${parseInt(p.jumlah).toLocaleString('id-ID')}</span>
                                      </div>
                                  </label>
                              </div>
                          </div>`;
                      });
                      $('#debtList').html(html);
                      $('#debtSection').show();
                      updateSelectedDebtTotal();
                      $('html, body').animate({ scrollTop: $('#debtSection').offset().top - 100 }, 500);
                  }
              }
          });
      }

     $('#filterTanggal').on('change', function() {
         const tanggal = $(this).val();
         window.location.href = '{{ route("transaksi.index") }}?tanggal=' + tanggal;
     });

      $('input[name="tipePembayaran"]').on('change', function() {
          if ($('#bayarHutang').is(':checked')) {
              $('#hutangFields').slideDown();
          } else {
              $('#hutangFields').slideUp();
          }
      });

      $('input[name="memberStatus"]').on('change', function() {
          if (this.value === 'lama') {
              $('#memberSearchBox').show();
              $('#memberForm input').prop('readonly', true);
              $('#memberForm input').prop('placeholder', '');
          } else {
              $('#memberSearchBox').hide();
              $('#memberForm input').prop('readonly', false);
              $('#memberForm input').prop('placeholder', 'Masukkan nama pelanggan');
              $('#noHpPelanggan').prop('readonly', false);
              $('#noHpPelanggan').prop('placeholder', 'Masukkan nomor HP');
              $('#searchMember').val('');
              $('#memberResults').hide();
              $('#memberResults').empty();
          }
          resetMemberSelection();
      });

      let memberSearchResults = [];
      let memberSearchTimeout = null;

      $('#searchMember').on('input', function() {
          const query = $(this).val().trim();
          clearTimeout(memberSearchTimeout);

          if (query.length < 1) {
              $('#memberResults').hide();
              return;
          }

          memberSearchTimeout = setTimeout(() => {
              $.ajax({
                  url: '{{ route("transaksi.member.search") }}',
                  method: 'GET',
                  data: { q: query },
                  success: function(data) {
                      memberSearchResults = data;
                      if (data.length === 0) {
                          $('#memberResults').html('<div class="list-group-item text-muted">Tidak ditemukan</div>').show();
                          return;
                      }

                      let html = '';
                      data.forEach((member, i) => {
                          html += `<div class="list-group-item list-group-item-action cursor-pointer" data-index="${i}">
                              <div class="d-flex justify-content-between">
                                  <div>
                                      <strong>${member.nama_pelanggan}</strong><br>
                                      <small class="text-muted">No. Member: ${member.no_member} - ${member.no_hp}</small>
                                  </div>
                              </div>
                          </div>`;
                      });
                      $('#memberResults').html(html).show();
                  }
              });
          }, 300);
      });

      $(document).on('click', '#memberResults .list-group-item', function() {
          const idx = parseInt($(this).data('index'));
          if (!isNaN(idx) && memberSearchResults[idx]) {
              selectMember(memberSearchResults[idx]);
          }
      });

      function selectMember(member) {
          $('#noMember').val(member.no_member);
          $('#namaPelanggan').val(member.nama_pelanggan);
          $('#noHpPelanggan').val(member.no_hp);
          $('#searchMember').val(`${member.nama_pelanggan} (${member.no_hp})`);
          $('#memberResults').hide();
          $('#resetMemberBtn').show();
      }

      function resetMemberSelection() {
          $('#noMember').val('');
          $('#namaPelanggan').val('');
          $('#noHpPelanggan').val('');
          $('#searchMember').val('');
          $('#memberResults').hide();
          $('#memberResults').empty();
          $('#resetMemberBtn').hide();
      }

        $(document).ready(function() {
           @if(request('bayar_piutang'))
           const piutangId = '{{ request('bayar_piutang') }}';
           loadPiutangForTransaksi(piutangId);
           @endif
       });
 </script>
 @endsection
