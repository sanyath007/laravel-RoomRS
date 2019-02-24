app.controller('reservationCtrl', function(CONFIG, $scope, $http, toaster, ModalService, StringFormatService, PaginateService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.creditors = [];
    $scope.payments = [];
    $scope.pager = [];
    $scope.pages = [];
    $scope.totalDebt = 0.00;
    $scope.loading = false;
    
    $scope.reserve_room = "";
    $scope.reserve_layout = "";

    $scope.changeRoomImg = function() {
        console.log($scope.reserve_room);
        console.log($("#img_room > img").attr("src", "http://localhost/laravel-roomRS/public/uploads/rooms/" +$scope.reserve_room+ "/thumbnail.jpg"));
    };

    $scope.changeLayoutImg = function() {
        console.log($scope.reserve_layout);
        $http.get(CONFIG.BASE_URL+ '/reserve/ajaxlayout/' +$scope.reserve_layout)
        .then(function(res) {
            console.log(res);
            console.log($("#img_layout > img").attr("src", "http://localhost/laravel-roomRS/public/uploads/layouts/" +res.data.reserve_layout_img));
        }, function(err) {
            console.log(err);
            toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
        });
    };

    $scope.changeCheckboxValue = function() {
        console.log($(event.target).val())

        if($(event.target).val() != 9){
            $.each($('#reserve_equipment input[type="checkbox"]'), function(index, chk) {
                if($(chk).val() == 9){
                    console.log(chk);
                    $(chk).prop('checked', false);
                }
            });
        } else {
            $.each($('#reserve_equipment input[type="checkbox"]'), function(index, chk) {
                if($(chk).val() != 9){
                    console.log(chk);
                    $(chk).prop('checked', false);
                }
            });
        }
    };

    $scope.getArrearData = function(URL) {
        $scope.debts = [];
        $scope.pager = [];
        
        if($("#showall:checked").val() != 'on' && ($("#debtType").val() == '' && $("#creditor").val() == '')) {
            toaster.pop('warning', "", "กรุณาเลือกเจ้าหนี้หรือประเภทหนี้ก่อน !!!");
        } else {
            $scope.loading = true;

            var debtDate = ($("#debtDate").val()).split(",");
            var sDate = debtDate[0].trim();
            var eDate = debtDate[1].trim();
            var debtType = ($("#debtType").val() == '') ? '0' : $("#debtType").val();
            var creditor = ($("#creditor").val() == '') ? '0' : $("#creditor").val();
            var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;
            
            $http.get(CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +creditor+ '/' +sDate+ '/' +eDate+ '/' + showAll)
            .then(function(res) {
                console.log(res);
                $scope.debts = res.data.debts.data;
                $scope.pager = res.data.debts;
                $scope.totalDebt = res.data.totalDebt;

                $scope.pages = PaginateService.createPagerNo($scope.pager);

                console.log($scope.pages);
                $scope.loading = false;
            }, function(err) {
                console.log(err);
                $scope.loading = false;
            });
        }
    };

    $scope.getArrearWithURL = function(URL) {
        $scope.debts = [];
        $scope.pager = [];
        $scope.loading = true;
            
        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.debts = res.data.debts.data;
            $scope.pager = res.data.debts;
            $scope.totalDebt = res.data.totalDebt;

            $scope.pages = PaginateService.createPagerNo($scope.pager);

            console.log($scope.pages);
            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    };

    $scope.arrearToExcel = function(URL) {
        console.log($scope.debts);

        if($scope.debts.length == 0) {
            toaster.pop('warning', "", "ไม่พบข้อมูล !!!");
        } else {
            var debtDate = ($("#debtDate").val()).split(",");
            var sDate = debtDate[0].trim();
            var eDate = debtDate[1].trim();
            var debtType = ($("#debtType").val() == '') ? '0' : $("#debtType").val();
            var creditor = ($("#creditor").val() == '') ? '0' : $("#creditor").val();
            var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;

            window.location.href = CONFIG.BASE_URL +URL+ '/' +debtType+ '/' +creditor+ '/' +sDate+ '/' +eDate+ '/' + showAll;
        }
    };
});