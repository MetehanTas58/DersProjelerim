import jQuery from "jquery";
window.$= jQuery

import Swal from "sweetalert2";
window.Swal=Swal

import axios from "axios";
window.axios=axios

import 'datatables.net';
import 'datatables.net-select';

$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$("meta[name='csrf-token']").attr('content')
    }
});

$.extend(true, $.fn.dataTable.defaults, {
    language: {
        info: "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
        infoEmpty: "Kayıt yok",
        infoFiltered: "(_MAX_ kayıt içerisinden bulunan)",
        infoThousands: ".",
        lengthMenu: "Sayfada _MENU_ kayıt göster",
        loadingRecords: "Yükleniyor...",
        processing: "İşleniyor...",
        search: "Ara:",
        zeroRecords: "Eşleşen kayıt bulunamadı",
        paginate: {
            first: "İlk",
            last: "Son",
            next: "Sonraki",
            previous: "Önceki"
        },
        aria: {
            sortAscending: ": artan sütun sıralamasını aktifleştir",
            sortDescending: ": azalan sütun sıralamasını aktifleştir"
        },
        select: {
            rows: {
                _: "%d kayıt seçildi",
                0: "",
                1: "1 kayıt seçildi"
            }
        }
    }
});