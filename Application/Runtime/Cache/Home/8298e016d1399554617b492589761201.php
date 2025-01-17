<?php if (!defined('THINK_PATH')) exit();?>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main.css?v=1.0"/>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=097de6dbe729c5e3f7c85c96c78dd1c7&plugin=AMap.DistrictSearch"></script>

    <style type="text/css">
        #mapContainerS{
            margin-left: 140px;
            border-radius: 4px;
            width: 604px;
            border: 1px solid #dedede;
            height: 404px;
            margin-bottom: 20px;
        }
        #mapContainer{
            position: relative;
            width: 600px;
            height: 400px
        }
    </style>


    <div class="form-inline">
        <label class="left" >工作区域:</label>
        <select id='province'  style="width:155px;" class="form-control" onchange='search(this)'></select>
        <select id='city'      style="width:155px;" class="form-control" onchange='search(this)'></select>
        <select id='district'  style="width:155px;" class="form-control"onchange='search(this)'></select>
    <!--街道：<select id='street' style="width:100px" onchange= 'setCenter(this)'></select>-->

    </div>
    <div id="mapContainerS">
        <div id="mapContainer"></div>
    </div>

    <input type="hidden" name="area_1" id="area_1" value="<?=$areaArr[0]?>"/>
    <input type="hidden" name="area_2" id="area_2" value="<?=$areaArr[1]?>"/>
    <input type="hidden" name="area_3" id="area_3" value="<?=$areaArr[2]?>"/>
    <input type="hidden" name="area_bounds" id="area_bounds" value="<?=$areaDetail?>"/>

    <input type="hidden"  id="edit_area_1" value="<?=$areaArr[0]?>"/>
    <input type="hidden"  id="edit_area_2" value="<?=$areaArr[1]?>"/>
    <input type="hidden"  id="edit_area_3" value="<?=$areaArr[2]?>"/>
    <input type="hidden"  id="area_edit" value="<?=$areaDetail?>"/>
<script type="text/javascript">
    var map, district, polygons = [], citycode;
    var citySelect = document.getElementById('city');
    var districtSelect = document.getElementById('district');
//    var areaSelect = document.getElementById('street');

    map = new AMap.Map('mapContainer', {
        resizeEnable: true,
//        center: [116.30946, 39.937629],
        center: [104.06667,30.66667],
        zoom: 11
    });
    //行政区划查询
    var opts = {
        subdistrict: 1,   //返回下一级行政区
        level: 'city',
        showbiz:false  //查询行政级别为 市
    };
    district = new AMap.DistrictSearch(opts);//注意：需要使用插件同步下发功能才能这样直接使用
    district.search('中国', function(status, result) {
        if(status=='complete'){
            getData(result.districtList[0]);
        }
    });
    if($('#area_edit').val()){
//        var contentSub2 = '<option value="" selected="selected">'+$('#edit_area_2').val()+'</option>'
//        var contentSub3 = '<option value="" selected="selected">'+$('#edit_area_3').val()+'</option>'
//        $('#city').append(contentSub2);
//        $('#district').append(contentSub3);

        loadDisList($('#edit_area_1').val(),'city');
        loadDisList($('#edit_area_2').val(),'district');
        addArea($('#edit_area_3').val())
    }
    $('#area_edit').val('');
    function loadDisList(districtName,id){
        district.search(districtName, function(status, result) {
            if(status=='complete'){
                var subList = result.districtList[0].districtList;
                for (var i = 0, l = subList.length; i < l; i++) {
                    var name = subList[i].name;
                    var levelSub = subList[i].level;


                    var contentSub=new Option(name);
                    contentSub.setAttribute("value", levelSub);

                    contentSub.center = subList[i].center;
                    contentSub.adcode = subList[i].adcode;
                    $('#edit_area_2').val()==name && contentSub.setAttribute("selected", 'true');
                    $('#edit_area_3').val()==name && contentSub.setAttribute("selected", 'true');
                    document.querySelector('#'+id).add(contentSub);
                }
            }
        });
    }
    function getData(data) {
        var bounds = data.boundaries;
        if (bounds) {
            $('#area_bounds').val(bounds);
            for (var i = 0, l = bounds.length; i < l; i++) {
                var polygon = new AMap.Polygon({
                    map: map,
                    strokeWeight: 1,
                    strokeColor: '#CC66CC',
                    fillColor: '#CCF3FF',
                    fillOpacity: 0.5,
                    path: bounds[i]
                });
                polygons.push(polygon);
            }
            map.setFitView();//地图自适应
        }

        var subList = data.districtList;
        var level = data.level;

        //清空下一级别的下拉列表
        if (level === 'province') {
            nextLevel = 'city';

            citySelect.innerHTML = '';
            districtSelect.innerHTML = '';
//            areaSelect.innerHTML = '';
            $('#area_2').val('');
            $('#area_3').val('');
        } else if (level === 'city') {
            nextLevel = 'district';
            districtSelect.innerHTML = '';
//            areaSelect.innerHTML = '';
            $('#area_3').val('');

        } else if (level === 'district') {
            nextLevel = 'street';
//            areaSelect.innerHTML = '';
        }
        if (subList) {
            var contentSub =new Option('--请选择--');
            for (var i = 0, l = subList.length; i < l; i++) {
                var name = subList[i].name;
                var levelSub = subList[i].level;
                var cityCode = subList[i].citycode;
                if(i==0){
                    document.querySelector('#' + levelSub).add(contentSub);
                }
                contentSub=new Option(name);
                contentSub.setAttribute("value", levelSub);
                $('#edit_area_1').val()==name && contentSub.setAttribute("selected", 'true');
                $('#edit_area_2').val()==name && contentSub.setAttribute("selected", 'true');
                $('#edit_area_3').val()==name && contentSub.setAttribute("selected", 'true');
                contentSub.center = subList[i].center;
                contentSub.adcode = subList[i].adcode;
                //.log(contentSub)
                document.querySelector('#' + levelSub).add(contentSub);
            }

        }

    }
    function search(obj) {
        //清除地图上所有覆盖物
        for (var i = 0, l = polygons.length; i < l; i++) {
            polygons[i].setMap(null);
        }
        var option = obj[obj.options.selectedIndex];
        var keyword = option.text; //关键字
        var adcode = option.adcode;

        var idName= obj.id;
        if(idName=='province'){
            $('#area_1').val(keyword);
            $('#area_2').val('');
            $('#area_3').val('');
        }
        if(idName=='city'){
            $('#area_2').val(keyword);
            $('#area_3').val('');
        }
        if(idName=='district'){
            $('#area_3').val(keyword);

        }
        district.setLevel(option.value); //行政区级别
        district.setExtensions('all');
        //行政区查询
        //按照adcode进行查询可以保证数据返回的唯一性
        district.search(adcode, function(status, result) {
            if(status === 'complete'){
                console.log(result.districtList[0])
                getData(result.districtList[0]);
            }
        });
    }
    function setCenter(obj){
        map.setCenter(obj[obj.options.selectedIndex].center)
    }
    function addArea(districts) {
        console.log(district)
        //加载行政区划插件
        AMap.service('AMap.DistrictSearch', function() {
            var opts = {
                subdistrict: 1,   //返回下一级行政区
                extensions: 'all',  //返回行政区边界坐标组等具体信息
                level: 'district'  //查询行政级别为 市
            };
            //实例化DistrictSearch
            district = new AMap.DistrictSearch(opts);
            district.setLevel('district');
            //行政区查询
            district.search(districts, function(status, result) {
                var bounds = result.districtList[0].boundaries;
                var polygons = [];
                if (bounds) {
                    for (var i = 0, l = bounds.length; i < l; i++) {
                        //生成行政区划polygon
                        var polygon = new AMap.Polygon({
                            map: map,
                            strokeWeight: 1,
                            path: bounds[i],
                            fillOpacity: 0.7,
                            fillColor: '#CCF3FF',
                            strokeColor: '#CC66CC'
                        });
                        polygons.push(polygon);
                    }
                    map.setFitView();//地图自适应
                }
            });
        });
    }
</script>
<script type="text/javascript" src="http://webapi.amap.com/demos/js/liteToolbar.js"></script>