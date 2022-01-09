font_size = 30
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
        this.apiUrl = apiUrl + "device/data";
        this.label1 = this.parent.getElementsByClassName('showLabel1')[0];
        this.loadDiv = this.parent.getElementsByClassName('load')[0];
        console.log(this.loadDiv)
        this.label2 = this.parent.getElementsByClassName('showLabel2')[0];
        this.label3 = this.parent.getElementsByClassName('showLabel3')[0];
        this.TimeLabel = this.parent.getElementsByClassName('TimeLabel')[0];
        this.updateTimeLabel = this.parent.getElementsByClassName('updateTimeLabel')[0];
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
        this.html = "";
        this.setHtml(id);
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
        if (indexChange !== 0)
            this.changeColor();

        let pageI = this.getPageIndex() + indexChange;
        let pageMax = this.getMaxPageIndex();
        let pageMin = this.getMinPageIndex();
        if (pageI === pageMax + 1)
            pageI = pageMin;
        if (pageI === pageMin - 1)
            pageI = pageMax;
        this.setPageIndex(pageI);

        if (indexChange !== 0)
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
        this.loadDiv.style.display = ""
        this.label1.innerHTML = "";
        this.label2.innerHTML = "";
        this.label3.innerHTML = "";

        let label1 = this.label1;
        let label2 = this.label2;
        let label3 = this.label3;
        let loadDiv = this.loadDiv;
        let TimeLabel = this.TimeLabel;
        let updateTimeLabel = this.updateTimeLabel;
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
                TimeLabel.innerHTML       = 'last data time :' + result[3];
                updateTimeLabel.innerHTML = 'update time :' + result[4];
                loadDiv.style.display = "none"
            }
        });
    }

    setHtml(){
        let regExp = /%id/g;
        let tempHtml = Schneider_PM2100_HTML();
        tempHtml.replace(regExp, this.id);
        this.html = tempHtml;
    }

    getField() {
        let pageIndex = this.getPageIndex()
        switch (this.sectionIndex) {
            case 1:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Voltage_A_N,1)','ROUND(Voltage_B_N,1)','ROUND(Voltage_C_N,1)'];

                    case 2:
                        return ['ROUND(Voltage_A_B,1)','ROUND(Voltage_B_C,1)','ROUND(Voltage_C_A,1)'];

                    case 3:
                        return ['ROUND(Current_A,1)','ROUND(Current_B,1)','ROUND(Current_C,1)'];

                    case 4:
                        return ['ROUND(Apparent_Power_A,1)','ROUND(Apparent_Power_B,1)','ROUND(Apparent_Power_C,1)'];

                    case 5:
                        return ['ROUND(Active_Power_A,1)','ROUND(Active_Power_B,1)','ROUND(Active_Power_C,1)'];

                    case 6:
                        return ['ROUND(Reactive_Power_A,1)','ROUND(Reactive_Power_B,1)','ROUND(Reactive_Power_C,1)'];

                    case 7:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];

                    case 8:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_C,1)','ROUND(Voltage_B_N,1)'];

                    case 9:
                        return ['ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)','ROUND(Current_A,1)'];
                    default:
                        return null;
                }

            case 2:
                switch (pageIndex) {
                    case 1:
                        return [null,null,'ROUND(Active_Energy_Delivered_Into_Load,1)'];


                    case 2:
                        return [null,null,'ROUND(Apparent_Energy_Delivered,1)'];

                    case 3:
                        return [null,null,'ROUND(Reactive_Energy_Delivered,1)'];

                    case 4:
                        return [null,null,'ROUND(Active_Energy_Received_Out_of_Load,1)'];

                    case 5:
                        return [null,null,'ROUND(Reactive_Energy_Received,1)'];

                    case 6:
                        return [null,null,'ROUND(Apparent_Energy_Received,1)'];
                    default:
                        return null;

                }


            case 3:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Apparent_Power_Total,1)','ROUND(Reactive_Power_Total,1)','ROUND(Active_Power_Total,1)'];

                    case 2:
                        return ['ROUND(Current_Avg,1)','ROUND(Reactive_Power_Total,1)','ROUND(Active_Power_Total,1)'];
                    default:
                        return null;
                }


            case 4:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Reactive_Power_Total,1)'];
                    default:
                        return null;
                }


            case 5:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Reactive_Energy_Delivered_Neg_Received,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];
                    default:
                        return null;
                }


            case 6:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Active_Energy_Delivered_Neg_Received,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];
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
                        return ['ROUND(Current_Avg,1)','ROUND(Power_Factor_Total,1)','ROUND(Voltage_L_N_Avg,1)'];

                    case 2:
                        return ['ROUND(Apparent_Power_Total,1)','ROUND(Reactive_Power_Total,1)','ROUND(Active_Power_Total,1)'];

                    case 3:
                        return ['ROUND(Frequency,1)','ROUND(Current_Unbalance_Worst,1)','ROUND(Power_Factor_C,1)'];
                    default:
                        return null;

                }


            default:
                return null;
        }

    }

}
class Schneider_PM2200 {
    constructor(id,substation_id,unit_id,themeUrl,apiUrl, offColor = "#000000", onColor = "#FF0000") {
        this.id = id;
        this.substation_id = substation_id;
        this.unit_id = unit_id;
        this.parent = document.getElementById("Schneider_PM2200_" + this.id);
        this.parent.style.background = "url('" + themeUrl + "assets/img/Schneider_PM2200.jpg') no-repeat";
        this.parent.style.backgroundSize = "auto 100%";
        this.parent.style.backgroundPosition = "center";
        this.parent.style.maxWidth = "430px";
        this.parent.style.minWidth = "430px";
        this.parent.style.maxHeight = "425px";
        this.parent.style.minHeight = "425px";
        this.apiUrl = apiUrl + "device/data";
        this.label1 = this.parent.getElementsByClassName('showLabel1')[0];
        this.label2 = this.parent.getElementsByClassName('showLabel2')[0];
        this.label3 = this.parent.getElementsByClassName('showLabel3')[0];
        this.TimeLabel = this.parent.getElementsByClassName('TimeLabel')[0];
        this.updateTimeLabel = this.parent.getElementsByClassName('updateTimeLabel')[0];
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
        this.html = "";
        this.setHtml(id);
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
        let TimeLabel = this.TimeLabel;
        let updateTimeLabel = this.updateTimeLabel;
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
                TimeLabel.innerHTML       = 'last data time :' + result[3];
                updateTimeLabel.innerHTML = 'update time :' + result[4];
            }
        });
    }

    setHtml(){
        let regExp = /%id/g;
        let tempHtml = Schneider_PM2200_HTML();
        tempHtml.replace(regExp, this.id);
        this.html = tempHtml;
    }

    getField() {
        let pageIndex = this.getPageIndex()
        switch (this.sectionIndex) {
            case 1:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Voltage_A_N,1)','ROUND(Voltage_B_N,1)','ROUND(Voltage_C_N,1)'];

                    case 2:
                        return ['ROUND(Voltage_A_B,1)','ROUND(Voltage_B_C,1)','ROUND(Voltage_C_A,1)'];

                    case 3:
                        return ['ROUND(Current_A,1)','ROUND(Current_B,1)','ROUND(Current_C,1)'];

                    case 4:
                        return ['ROUND(Apparent_Power_A,1)','ROUND(Apparent_Power_B,1)','ROUND(Apparent_Power_C,1)'];

                    case 5:
                        return ['ROUND(Active_Power_A,1)','ROUND(Active_Power_B,1)','ROUND(Active_Power_C,1)'];

                    case 6:
                        return ['ROUND(Reactive_Power_A,1)','ROUND(Reactive_Power_B,1)','ROUND(Reactive_Power_C,1)'];

                    case 7:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];

                    case 8:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_C,1)','ROUND(Voltage_B_N,1)'];

                    case 9:
                        return ['ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)','ROUND(Current_A,1)'];
                    default:
                        return null;
                }

            case 2:
                switch (pageIndex) {
                    case 1:
                        return [null,null,'ROUND(Active_Energy_Delivered_Into_Load,1)'];


                    case 2:
                        return [null,null,'ROUND(Apparent_Energy_Delivered,1)'];

                    case 3:
                        return [null,null,'ROUND(Reactive_Energy_Delivered,1)'];

                    case 4:
                        return [null,null,'ROUND(Active_Energy_Received_Out_of_Load,1)'];

                    case 5:
                        return [null,null,'ROUND(Reactive_Energy_Received,1)'];

                    case 6:
                        return [null,null,'ROUND(Apparent_Energy_Received,1)'];
                    default:
                        return null;

                }


            case 3:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Apparent_Power_Total,1)','ROUND(Reactive_Power_Total,1)','ROUND(Active_Power_Total,1)'];

                    case 2:
                        return ['ROUND(Current_Avg,1)','ROUND(Reactive_Power_Total,1)','ROUND(Active_Power_Total,1)'];
                    default:
                        return null;
                }


            case 4:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Reactive_Power_Total,1)'];
                    default:
                        return null;
                }


            case 5:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Reactive_Energy_Delivered_Neg_Received,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];
                    default:
                        return null;
                }


            case 6:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Active_Energy_Delivered_Neg_Received,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)','ROUND(Power_Factor_B,1)','ROUND(Power_Factor_C,1)'];
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
                        return ['ROUND(Current_Avg,1)','ROUND(Power_Factor_Total,1)','ROUND(Voltage_L_N_Avg,1)'];

                    case 2:
                        return ['ROUND(Apparent_Power_Total,1)','ROUND(Reactive_Power_Total,1)','ROUND(Active_Power_Total,1)'];

                    case 3:
                        return ['ROUND(Frequency,1)','ROUND(Current_Unbalance_Worst,1)','ROUND(Power_Factor_C,1)'];
                    default:
                        return null;

                }


            default:
                return null;
        }

    }

}

function   Schneider_PM2100_HTML (){
                                return  ('<div class="col-md-6 parent" id="Schneider_PM2100_%id" >' +
    '\n' +
    '                                <div class="col-md-3">\n' +
    '                                    <i class="fa fa-caret-right labelTemp label1  section8" aria-hidden="true"\n' +
    '                                       style="transform: translate(250%,170%);position: absolute; font-size: ' + font_size + 'px; color : #000000;"></i>\n' +
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
    '                                <div class="col-md-6" style="transform: translate(0%,0%);">\n' +
    '                                  <div class="load" style="transform: translate(-40%,100%);">\n' +
                            '            <div class="gear one">\n' +
                                    '                      <svg id="blue" viewBox="0 0 100 100" fill="#94DDFF">\n' +
                                    '                           <path\n' +
    '                                d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6              c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3              l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9              c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>\n' +
                                    '                         </svg>\n' +
                                    '                        </div>\n' +
                                    '   <div class="gear two">\n' +
                                    '       <svg id="pink" viewBox="0 0 100 100" fill="#FB8BB9">\n' +
                                '           <path\n' +
                                    '                   d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6              c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3              l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9              c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>\n' +
                                    '       </svg>\n' +
                                    '   </div>\n' +
                                    '   <div class="gear three">\n' +
                                    '       <svg id="yellow" viewBox="0 0 100 100" fill="#FFCD5C">\n' +
                                '           <path\n' +
                                    '                   d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6              c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3              l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9              c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>\n' +
                                    '       </svg>\n' +
                                    '   </div>\n' +
                                    '</div>\n' +
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
    '                                <div class="col-md-12 text-center" style="transform: translate(0%,-20%);">\n' +
    '                                    <label class="col-form-label text-center TimeLabel"\n' +
    '                                           style=" font-size: 20px; color : #0000ff;"></label>\n' +
    '                                </div>\n' +
    '                                <div class="col-md-12 text-center" style="transform: translate(0%,-20%);">\n' +
    '                                    <label class="col-form-label text-center updateTimeLabel"\n' +
    '                                           style=" font-size: 20px; color : #0000ff;"></label>\n' +
    '                                </div>\n' +
    '                            </div>'
                                )

}
function   Schneider_PM2200_HTML (){
                                return  ('<div class="col-md-6 parent" id="Schneider_PM2200_%id" >' +
        '<div class="col-md-3"></div>'+
   ' <div class="col-md-6" style="transform: translate(0%,0%);">'+
        '<div class="row" style="height: 125px">'+
            '<div class="col-md-12 text-center">'+
            '<label class="col-form-label text-center showLabel1"'+
                       'style="transform: translate(5%,120%); font-size: 36px; color : #2a2f35;"></label>'+
            '</div>'+
        '</div>'+
        '<div class="row" style="height: 125px">'+
            '<div class="col-md-3 "></div>'+
            '<div class="col-md-6 text-center">'+

               ' <label class="col-form-label text-center showLabel2"'+
                       'style="transform: translate(30%,60%); font-size: 36px; color : #2a2f35;"></label>'+
            '</div>'+
            '<div class="col-md-3 "></div>'+
        '</div>'+
        '<div class="row" style="height: 125px">'+
            '<div class="col-md-3 "></div>'+
            '<div class="col-md-6 text-center">'+

                '<label class="col-form-label text-center showLabel3"'+
                       'style="transform: translate(30%,-10%); font-size: 36px; color : #2a2f35;"></label>'+

            '</div>'+
            '<div class="col-md-3 "></div>'+
        '</div>'+
        '<div class="row">'+
            '<div style="width: 430px; margin: auto;height: 50px;">'+
                '<button type="button"'+
                        'style="color: transparent!important;padding: 10px!important;transform: translate(250%,-45%)"'+
                        'class="btn btn-link text-info" id="OkBut"><i'+
                    'style="width: 10px;"'+
                    'onclick=""'+
                    'class="fa fa-eye-slash"></i></button>'+
                '<button type="button"'+
                        'style="color: transparent!important;padding: 10px!important;transform: translate(180%,-45%)"'+
                        'class="btn btn-link text-info" id="UPButt"><i'+
                    'style="width: 10px;"'+
                    'onclick=""'+
                    'class="fa fa-eye-slash"></i></button>'+
                '<button type="button"'+
                        'style="color: transparent!important;padding: 10px!important;transform: translate(80%,-45%)"'+
                        'class="btn btn-link text-info" id="DownBut"><i'+
                    'style="width: 10px;"'+
                    'onclick=""'+
                    'class="fa fa-eye-slash"></i></button>'+
            '</div>'+
        '</div>'+
    '</div>'+
    '<div class="col-md-12 text-center" style="transform: translate(0%,-20%);">'+
        '<label class="col-form-label text-center TimeLabel"'+
               'style=" font-size: 20px; color : #0000ff;"></label>'+
    '</div>'+
    '<div class="col-md-12 text-center" style="transform: translate(0%,-20%);">'+
        '<label class="col-form-label text-center updateTimeLabel"'+
               'style=" font-size: 20px; color : #0000ff;"></label>'+
    '</div>'+
'</div>')

}

function   type_chooser(deviceType,id, substation_id, unitId, themeUrl,urlApi){
     switch (deviceType){
         case 1:
            return  new Schneider_PM2100(id, substation_id, unitId, themeUrl,urlApi);
         case 2:
            return  new Schneider_PM2200(id, substation_id, unitId, themeUrl,urlApi);
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
        case 2:
            tempHtml = Schneider_PM2200_HTML();
            break;
        default:
            tempHtml = '';
    }
    let regExp = /%id/g;
    return tempHtml.replace(regExp, id);
}