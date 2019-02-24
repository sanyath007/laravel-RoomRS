app.controller('equipmentCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.loading = false;
    $scope.pager = [];
    $scope.equipments = [];
    $scope.equipment = {
        equipment_id: '',
        equipment_name: ''
    };

    $scope.getData = function(event) {
        console.log(event);
        $scope.debttypes = [];
        $scope.loading = true;
        
        var searchKey = ($("#searchKey").val() == '') ? 0 : $("#searchKey").val();
        console.log(CONFIG.BASE_URL+ '/debttype/search/' +searchKey);

        $http.get(CONFIG.BASE_URL+ '/debttype/search/' +searchKey)
        .then(function(res) {
            console.log(res);
            $scope.debttypes = res.data.debttypes.data;
            $scope.pager = res.data.debttypes;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getDataWithURL = function(URL) {
        console.log(URL);
        $scope.debttypes = [];
        $scope.loading = true;

    	$http.get(URL)
    	.then(function(res) {
    		console.log(res);
            $scope.debttypes = res.data.debttypes.data;
            $scope.pager = res.data.debttypes;

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	});
    }

    $scope.add = function(event, form) {
        console.log(event);
        event.preventDefault();

        if (form.$invalid) {
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            $http.post(CONFIG.BASE_URL + '/equipment/store', $scope.debttype)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });            
        }

        document.getElementById('frmNewEquipment').reset();
    }

    $scope.getDebttype = function(debttypeId) {
        $http.get(CONFIG.BASE_URL + '/debttype/get-debttype/' +debttypeId)
        .then(function(res) {
            console.log(res);
            $scope.debttype = res.data.debttype;
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(equipmentId) {
        console.log(equipmentId);

        window.location.href = CONFIG.BASE_URL + '/equipment/edit/' + equipmentId;
    };

    $scope.update = function(event, form, equipmentId) {
        console.log(equipmentId);
        event.preventDefault();

        if(confirm("คุณต้องแก้ไขรายการหนี้เลขที่ " + equipmentId + " ใช่หรือไม่?")) {
            $http.put(CONFIG.BASE_URL + '/equipment/update/', $scope.equipment)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'แก้ไขข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };

    $scope.delete = function(equipmentId) {
        console.log(equipmentId);

        if(confirm("คุณต้องลบรายการหนี้เลขที่ " + equipmentId + " ใช่หรือไม่?")) {
            $http.delete(CONFIG.BASE_URL + '/equipment/delete/' +equipmentId)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'ลบข้อมูลเรียบร้อยแล้ว !!!');
                $scope.getData();
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };
});