"use strict";

$(function () {
    $("#dtTable").DataTable({
        responsive: true,
        aLengthMenu: [
            [5, 10, 25, -1],
            [5, 10, 25, "All"],
        ],
        order: [[0, "desc"]],
        iDisplayLength: 10,
    });

    $("#dtTable1").DataTable({
        responsive: true,
        aLengthMenu: [
            [5, 10, 25, -1],
            [5, 10, 25, "All"],
        ],
        order: [[0, "desc"]],
        iDisplayLength: 10,
    });
});
