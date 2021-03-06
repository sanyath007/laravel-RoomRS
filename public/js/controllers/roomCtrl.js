app.controller('roomCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    console.log(CONFIG.BASE_URL);
    let baseUrl = CONFIG.BASE_URL;

    $scope.loading = false;
    $scope.pager = [];
    $scope.rooms = [];
    $scope.room = {
        room_id: 'NEW',
        room_name: '',
        room_size: '',
        room_capacity: 0,
        room_locate: '',
        room_pay_rate: 0.0,
        room_reserv_max: 0,
        room_contact_tel: '',
        room_detail: '',
        room_color: ''
    };

    $scope.getData = function(event) {
        console.log(event);
        $scope.creditors = [];
        $scope.loading = true;
        
        var searchKey = ($("#searchKey").val() == '') ? 0 : $("#searchKey").val();
        console.log(CONFIG.BASE_URL+ '/creditor/search/' +searchKey);

        $http.get(CONFIG.BASE_URL+ '/creditor/search/' +searchKey)
        .then(function(res) {
            console.log(res);
            $scope.creditors = res.data.creditors.data;
            $scope.pager = res.data.creditors;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getDataWithURL = function(URL) {
        console.log(URL);
        $scope.creditors = [];
        $scope.loading = true;

    	$http.get(URL)
    	.then(function(res) {
    		console.log(res);
            $scope.creditors = res.data.creditors.data;
            $scope.pager = res.data.creditors;

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	});
    }

    $scope.add = function(event, form) {
        console.log(event);
        console.log(form.$invalid);
        console.log($scope.room);
        event.preventDefault();

        if (form.$invalid) {
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            $http.post(CONFIG.BASE_URL + '/room/store', $scope.room)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });            
        }

        document.getElementById('frmNewRoom').reset();
    }

    $scope.getRoom = function(roomId) {
        $http.get(CONFIG.BASE_URL + '/room/get-room/' +roomId)
        .then(function(res) {
            console.log(res);
            $scope.room = res.data.room;
            console.log($scope.room);
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(roomId) {
        console.log(roomId);

        window.location.href = CONFIG.BASE_URL + '/room/edit/' + roomId;
    };

    $scope.update = function(event, form, roomId) {
        console.log(event);
        console.log(form);
        console.log(roomId);
        event.preventDefault();

        if(confirm("คุณต้องแก้ไขเจ้าหนี้เลขที่ " + roomId + " ใช่หรือไม่?")) {
            $http.put(CONFIG.BASE_URL + '/room/update/', $scope.room)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'แก้ไขข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };

    $scope.delete = function(roomId) {
        console.log(roomId);

        if(confirm("คุณต้องลบห้องประชุม ID : " + roomId + " ใช่หรือไม่?")) {
            $http.delete(CONFIG.BASE_URL + '/room/delete/' +roomId)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'ลบข้อมูลเรียบร้อยแล้ว !!!');
                $scope.getData();
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });

            window.location.href = CONFIG.BASE_URL + '/room/list';
        }
    };
});