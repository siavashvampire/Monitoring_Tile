class Schneider_PM2100 {
    constructor(id,substation_id,unit_id,themeUrl,apiUrl, offColor = "#000000", onColor = "#FF0000") {
        this.id = id;
        this.substation_id = substation_id;
        this.unit_id = unit_id;
        this.parent = document.getElementById("Schneider_PM2100_" + this.id);
        this.parent.style.background = "url('" + themeUrl + "assets/img/Schneider_PM2100.jpg') no-repeat";
        this.parent.style.backgroundSize = "auto 100%";
        this.parent.style.backgroundPosition = "center";
        this.parent.style.maxWidth = "430px";
        this.parent.style.minWidth = "430px";
        this.parent.style.maxHeight = "425px";
        this.parent.style.minHeight = "425px";
        this.apiUrl = apiUrl + "get_device_data";
        this.label1 = this.parent.getElementsByClassName('showLabel1')[0];
        this.label2 = this.parent.getElementsByClassName('showLabel2')[0];
        this.label3 = this.parent.getElementsByClassName('showLabel3')[0];
        this.type = "Schneider_PM2100";
        this.type_Id = 1;
        this.tableName = "elecsub_data";
        this.offColor = offColor;
        this.onColor = onColor;
        this.pageIndex = [1, 1, 2, 2, 2, 2, 1, 1];
        this.minPageIndex = [1, 1, 2, 2, 2, 2, 1, 1];
        this.maxPageIndex = [9, 6, 2, 2, 2, 2, 1, 3];
        this.sectionIndex = 1;
        this.minSectionIndex = 1;
        this.maxSectionIndex = 8;
        this.setData();

    }

    getPageIndex() {
        return this.pageIndex[this.sectionIndex - 1]
    }

    getMaxPageIndex() {
        return this.maxPageIndex[this.sectionIndex - 1]
    }

    getMinPageIndex() {
        return this.minPageIndex[this.sectionIndex - 1]

    }

    setPageIndex(pageIndex) {
        this.pageIndex[this.sectionIndex - 1] = pageIndex;
    }

    changeIndex(indexChange = 0) {
        if (indexChange != 0)
            this.changeColor();

        let pageI = this.getPageIndex() + indexChange;
        let pageMax = this.getMaxPageIndex();
        let pageMin = this.getMinPageIndex();
        if (pageI == pageMax + 1)
            pageI = pageMin;
        if (pageI == pageMin - 1)
            pageI = pageMax;
        this.setPageIndex(pageI);

        if (indexChange != 0)
            this.changeColor(1);
        this.setData();
    }

    changeSection(sectionChange = 1) {
        this.changeColor();
        let sectionI = this.sectionIndex + sectionChange;
        if (sectionI == this.maxSectionIndex + 1)
            sectionI = this.minSectionIndex;
        if (sectionI == this.minSectionIndex - 1)
            sectionI = this.maxSectionIndex;
        this.sectionIndex = sectionI;
        this.changeColor(1);
        this.setData();
    }

    changeColor(state = 0) {
        if (state == 0) {
            let label = this.parent.getElementsByClassName('labelTemp')
            for (let i = 0; i < label.length; i++)
                label[i].style.color = this.offColor;
        }
        if (state == 1) {
            let label = this.parent.getElementsByClassName('label' + this.getPageIndex() + ' section' + this.sectionIndex)
            for (let i = 0; i < label.length; i++)
                label[i].style.color = this.onColor;
        }
    }

    setData() {
        let label1 = this.label1;
        let label2 = this.label2;
        let label3 = this.label3;
        let field = this.getField();
        let tableName = this.tableName;
        let unit_id = this.unit_id;
        let substation_id = this.substation_id;
        $.ajax({
            url: this.apiUrl,
            type: 'post',
            dataType: 'json',
            data: {
                'unit_id':unit_id ,
                'substation_id': substation_id,
                'field': field,
                'tableName': tableName,
            } ,
            success: function (result) {
                label1.innerHTML = result[0];
                label2.innerHTML = result[1];
                label3.innerHTML = result[2];
            }
        });

    }

    getField() {
        let pageIndex = this.getPageIndex()
        switch (this.sectionIndex) {
            case 1:
                switch (pageIndex) {
                    case 1:
                        return ['Voltage_A_N','Voltage_B_N','Voltage_C_N'];

                    case 2:
                        return ['Voltage_A_B','Voltage_B_C','Voltage_C_A'];

                    case 3:
                        return ['Current_A','Current_B','Current_C'];

                    case 4:
                        return ['Apparent_Power_A','Apparent_Power_B','Apparent_Power_C'];

                    case 5:
                        return ['Active_Power_A','Active_Power_B','Active_Power_C'];

                    case 6:
                        return ['Reactive_Power_A','Reactive_Power_B','Reactive_Power_C'];

                    case 7:
                        return ['Power_Factor_A','Power_Factor_B','Power_Factor_C'];

                    case 8:
                        return ['Power_Factor_A','Power_Factor_C','Voltage_B_N'];

                    case 9:
                        return ['Power_Factor_B','Power_Factor_C','Current_A'];
                    default:
                        return null;
                }

            case 2:
                switch (pageIndex) {
                    case 1:
                        return [null,null,'Active_Energy_Delivered_Into_Load'];


                    case 2:
                        return [null,null,'Apparent_Energy_Delivered'];

                    case 3:
                        return [null,null,'Reactive_Energy_Delivered'];

                    case 4:
                        return [null,null,'Active_Energy_Received_Out_of_Load'];

                    case 5:
                        return [null,null,'Reactive_Energy_Received'];

                    case 6:
                        return [null,null,'Apparent_Energy_Received'];
                    default:
                        return null;

                }


            case 3:
                switch (pageIndex) {
                    case 1:
                        return ['Apparent_Power_Total','Reactive_Power_Total','Active_Power_Total'];

                    case 2:
                        return ['Current_Avg','Reactive_Power_Total','Active_Power_Total'];
                    default:
                        return null;
                }


            case 4:
                switch (pageIndex) {
                    case 1:
                        return ['Power_Factor_A','Power_Factor_B','Power_Factor_C'];

                    case 2:
                        return ['Power_Factor_A','Power_Factor_B','Reactive_Power_Total'];
                    default:
                        return null;
                }


            case 5:
                switch (pageIndex) {
                    case 1:
                        return ['Reactive_Energy_Delivered_Neg_Received','Power_Factor_B','Power_Factor_C'];

                    case 2:
                        return ['Power_Factor_A','Power_Factor_B','Power_Factor_C'];
                    default:
                        return null;
                }


            case 6:
                switch (pageIndex) {
                    case 1:
                        return ['Active_Energy_Delivered_Neg_Received','Power_Factor_B','Power_Factor_C'];

                    case 2:
                        return ['Power_Factor_A','Power_Factor_B','Power_Factor_C'];
                    default:
                        return null;
                }


            case 7:
                switch (pageIndex) {
                    case 1:
                        return ['DATE_FORMAT(JStart_time, "%Y")','DATE_FORMAT(JStart_time, "%m.%d")','DATE_FORMAT(Start_time, "%H.%i")'];
                    default:
                        return null;
                }


            case 8:
                switch (pageIndex) {
                    case 1:
                        return ['Current_Avg','Power_Factor_Total','Voltage_L_N_Avg'];

                    case 2:
                        return ['Apparent_Power_Total','Reactive_Power_Total','Active_Power_Total'];

                    case 3:
                        return ['Frequency','Current_Unbalance_Worst','Power_Factor_C'];
                    default:
                        return null;

                }


            default:
                return null;
        }

    }

}
function   Schneider_PM2100_HTML (){
                                return  ('<div class="col-md-6 parent" id=Schneider_PM2100_%id >' +
    '\n' +
    '                                <div class="col-md-3">\n' +
    '                                    <i class="fa fa-caret-right labelTemp label1  section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,170%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label2  section8 section3 section4 section5 section6"\n' +
    '                                       aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,250%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label3 section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,325%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label4 section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,405%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label1  section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,485%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label2  section8 section3 section4 section5 section6"\n' +
    '                                       aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,560%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label3  section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,640%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label3  section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,720%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label1  section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,800%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label2 section8 section3 section4 section5 section6"\n' +
    '                                       aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,880%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label3  section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,960%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label4  section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,1050%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label3 label6  section2" aria-hidden="true"\n' +
    '                                       style="transform: translate(-650%,1110%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label2 label5  section2" aria-hidden="true"\n' +
    '                                       style="transform: translate(-1280%,1110%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-right labelTemp label1 label4  section2" aria-hidden="true"\n' +
    '                                       style="transform: translate(-1900%,1110%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '                                </div>\n' +
    '                                <div class="col-md-6">\n' +
    '                                    <div class="row" style="height: 125px">\n' +
    '                                        <div class="col-md-12 text-center">\n' +
    '                                            <label class="col-form-label text-center showLabel1"\n' +
    '                                                   style="transform: translate(5%,20%); font-size: 72px; color : #ff0000;"></label>\n' +
    '                                        </div>\n' +
    '                                    </div>\n' +
    '                                    <div class="row" style="height: 125px">\n' +
    '                                        <div class="col-md-3 "></div>\n' +
    '                                        <div class="col-md-6 text-center">\n' +
    '\n' +
    '                                            <label class="col-form-label text-center showLabel2"\n' +
    '                                                   style="transform: translate(30%,-5%); font-size: 72px; color : #ff0000;"></label>\n' +
    '\n' +
    '                                        </div>\n' +
    '                                        <div class="col-md-3 "></div>\n' +
    '                                    </div>\n' +
    '                                    <div class="row" style="height: 125px">\n' +
    '                                        <div class="col-md-3 "></div>\n' +
    '                                        <div class="col-md-6 text-center">\n' +
    '\n' +
    '                                            <label class="col-form-label text-center showLabel3"\n' +
    '                                                   style="transform: translate(30%,-30%); font-size: 72px; color : #ff0000;"></label>\n' +
    '\n' +
    '                                        </div>\n' +
    '                                        <div class="col-md-3 "></div>\n' +
    '                                    </div>\n' +
    '                                    <div class="row">\n' +
    '                                        <div style="width: 430px; margin: auto;height: 50px;">\n' +
    '                                            <button type="button"\n' +
    '                                                    style="color: transparent!important;padding: 10px!important;transform: translate(250%,-45%)"\n' +
    '                                                    class="btn btn-link text-info" id="OkBut"><i\n' +
    '                                                    style="width: 10px;"\n' +
    '                                                    onclick="device_class[%id].changeSection()"\n' +
    '                                                    class="fa fa-eye-slash"></i></button>\n' +
    '                                            <button type="button"\n' +
    '                                                    style="color: transparent!important;padding: 10px!important;transform: translate(180%,-45%)"\n' +
    '                                                    class="btn btn-link text-info" id="UPButt"><i\n' +
    '                                                    style="width: 10px;"\n' +
    '                                                    onclick="device_class[%id].changeIndex(-1)"\n' +
    '                                                    class="fa fa-eye-slash"></i></button>\n' +
    '                                            <button type="button"\n' +
    '                                                    style="color: transparent!important;padding: 10px!important;transform: translate(80%,-45%)"\n' +
    '                                                    class="btn btn-link text-info" id="DownBut"><i\n' +
    '                                                    style="width: 10px;"\n' +
    '                                                    onclick="device_class[%id].changeIndex(1)"\n' +
    '                                                    class="fa fa-eye-slash"></i></button>\n' +
    '                                        </div>\n' +
    '                                    </div>\n' +
    '                                </div>\n' +
    '                                <div class="col-md-3">\n' +
    '                                    <i class="fa fa-caret-left labelTemp label1 section1" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,180%);position: absolute; font-size: 30px; color : #ff0000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label2 section1" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,270%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label3 section1" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,350%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label4  section1" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,430%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label5 section1" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,510%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label6 section1" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,590%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label7 section1" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,670%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label8 section1" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,750%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label9 section1" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,830%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label2 section3" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,930%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label2 section4" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,1010%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label2 section5" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,1090%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label2 section6" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,1165%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                    <i class="fa fa-caret-left labelTemp label1 section7" aria-hidden="true"\n' +
    '                                       style="transform: translate(470%,1250%);position: absolute; font-size: 30px; color : #000000;"></i>\n' +
    '\n' +
    '                                </div>\n' +
    '                            </div>');

}
function   type_chooser(deviceType,id, substation_id, unitId, themeUrl,urlApi){
     switch (deviceType){
         case 1:
            return  new Schneider_PM2100(id, substation_id, unitId, themeUrl,urlApi);
         default:
             return null;
     }
 }
function getHtml(deviceType, id) {
    let tempHtml;
    switch (deviceType) {
        case 1:
            tempHtml = Schneider_PM2100_HTML();
            break;
        default:
            tempHtml = '';

    }
    let patt = /%id/g;
    return tempHtml.replace(patt, id);
}
