function selectTicket(ticketId) {
    var radioButton = document.getElementById(ticketId);
    radioButton.checked = true;

    var radioButtons = document.querySelectorAll("input[name='ticket']");
    var selectedPrice = 0;

    var ticketItems = document.querySelectorAll('.ticket-item');
    ticketItems.forEach(function(item) {
        item.classList.remove('selected');
    });

    radioButtons.forEach(function(radioButton) {
        if (radioButton.checked) {
            selectedPrice = parseInt(radioButton.getAttribute('data-harga'));
            radioButton.closest('.ticket-item').classList.add('selected');
            document.getElementById('id_tiket').value = ticketId;
            document.getElementById('total_harga').value = selectedPrice * document.getElementById('jumlahTiket').value;
        }
    });

    var jumlahTiket = document.getElementById('jumlahTiket').value;
    var totalHarga = selectedPrice * jumlahTiket;
    document.getElementById('totalHarga').innerText = 'Rp ' + totalHarga.toLocaleString('id-ID');
}

document.getElementById('jumlahTiket').addEventListener('input', function() {
    selectTicket(document.querySelector("input[name='ticket']:checked").id);
});

var radioButtons = document.querySelectorAll("input[name='ticket']");
radioButtons.forEach(function(radioButton) {
    radioButton.addEventListener('change', function() {
        selectTicket(radioButton.id);
    });
});

var ticketItems = document.querySelectorAll('.ticket-item');
ticketItems.forEach(function(item) {
    item.addEventListener('click', function() {
        selectTicket(item.querySelector("input[name='ticket']").id);
    });
});

document.getElementById('formbeli').addEventListener('submit', function(event) {
    event.preventDefault();

    var nama = document.getElementById('nama').value;
    var nomorTelepon = document.getElementById('nomorTelepon').value;
    var email = document.getElementById('email').value;
    var jumlahTiket = document.getElementById('jumlahTiket').value;
    var selectedTicket = document.querySelector("input[name='ticket']:checked");

    if (!selectedTicket) {
        alert('Harap pilih tiket terlebih dahulu.');
        return;
    }

    var jenisTiket = selectedTicket.closest('.ticket-details').querySelector('h2').innerText;
    var hargaTiket = parseInt(selectedTicket.getAttribute('data-harga'));
    var totalHarga = hargaTiket * jumlahTiket;
    var confirmation = confirm(
        'Nama: ' + nama + '\n' +
        'Nomor Telepon: ' + nomorTelepon + '\n' +
        'Email: ' + email + '\n' +
        'Jenis Tiket: ' + jenisTiket + '\n' +
        'Jumlah Tiket: ' + jumlahTiket + '\n' +
        'Total Harga: Rp ' + totalHarga.toLocaleString('id-ID') + '\n\n' +
        'Apakah Anda yakin ingin membeli tiket ini?'
    );

    if (confirmation) {
        document.getElementById('formbeli').submit();
    }
});