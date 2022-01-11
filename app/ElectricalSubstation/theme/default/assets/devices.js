caret_size = 30

class Schneider_PM21xx {
    constructor(id, substation_id, unit_id, type_Id, unit_name, image_name, parent_id, themeUrl, apiUrl) {
        this.id = id;
        this.substation_id = substation_id;
        this.type_Id = type_Id;
        this.unit_id = unit_id;
        this.unit_name = unit_name;
        this.image_name = image_name;
        this.parent = document.getElementById(parent_id + "_" + this.id);
        this.parent.style.background = "url('" + themeUrl + "assets/img/" + this.image_name + ".jpg') no-repeat";
        this.parent.style.backgroundSize = "auto 100%";
        this.parent.style.backgroundPosition = "center";
        this.parent.style.width = "420px";
        this.parent.style.height = "425px";
        this.apiUrl = apiUrl;
        this.tableName = "elecsub_data";
        this.loadDiv = this.parent.getElementsByClassName('load')[0];
        this.label1 = this.parent.getElementsByClassName('showLabel1')[0];
        this.label2 = this.parent.getElementsByClassName('showLabel2')[0];
        this.label3 = this.parent.getElementsByClassName('showLabel3')[0];
        this.TimeLabel = this.parent.getElementsByClassName('TimeLabel')[0];
        this.updateTimeLabel = this.parent.getElementsByClassName('updateTimeLabel')[0];
        this.pageIndex = [1, 1, 2, 2, 2, 2, 1, 1];
        this.minPageIndex = [1, 1, 2, 2, 2, 2, 1, 1];
        this.maxPageIndex = [9, 6, 2, 2, 2, 2, 1, 3];
        this.sectionIndex = 1;
        this.minSectionIndex = 1;
        this.maxSectionIndex = 8;
        this.html = "";
        this.setHtml(id);
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
        let pageI = this.getPageIndex() + indexChange;
        let pageMax = this.getMaxPageIndex();
        let pageMin = this.getMinPageIndex();
        if (pageI === pageMax + 1)
            pageI = pageMin;
        if (pageI === pageMin - 1)
            pageI = pageMax;
        this.setPageIndex(pageI);

        this.setData();
    }

    changeSection(sectionChange = 1) {
        let sectionI = this.sectionIndex + sectionChange;
        if (sectionI === this.maxSectionIndex + 1)
            sectionI = this.minSectionIndex;
        if (sectionI === this.minSectionIndex - 1)
            sectionI = this.maxSectionIndex;
        this.sectionIndex = sectionI;
        this.setData();
    }

    setData() {
    }

    setHtml() {
        let tempHtml
        let regExp;

        switch (this.type_Id) {
            case 1:
                tempHtml = Schneider_PM2100_HTML();
                break;
            case 2:
                tempHtml = Schneider_PM2200_HTML();
                break;
            default:
                tempHtml = Schneider_PM2100_HTML();
                break;

        }

        regExp = /%index/g;
        tempHtml = tempHtml.replace(regExp, this.id);
        regExp = /%caret_size/g;
        tempHtml = tempHtml.replace(regExp, caret_size);
        this.html = tempHtml;
    }
}

class Schneider_PM2100 extends Schneider_PM21xx {
    constructor(id, substation_id, unit_id, unit_name, themeUrl, apiUrl, offColor = "#000000", onColor = "#FF0000") {
        super(id, substation_id, unit_id, 1, unit_name, "Schneider_PM2100", "Schneider_PM2100", themeUrl, apiUrl);
        this.apiUrl = apiUrl + "device/data";
        this.type = "Schneider_PM2100";
        this.type_Id = 1;

        this.pageIndex = [1, 1, 2, 2, 2, 2, 1, 1];
        this.minPageIndex = [1, 1, 2, 2, 2, 2, 1, 1];
        this.maxPageIndex = [9, 6, 2, 2, 2, 2, 1, 3];
        this.sectionIndex = 1;
        this.minSectionIndex = 1;
        this.maxSectionIndex = 8;
        this.offColor = offColor;
        this.onColor = onColor;
        this.setData();
    }

    changeIndex(indexChange = 0) {
        if (indexChange !== 0)
            this.changeColor();

        super.changeIndex(indexChange)

        if (indexChange !== 0)
            this.changeColor(1);
    }

    changeSection(sectionChange = 1) {
        this.changeColor();
        super.changeSection(sectionChange)
        this.changeColor(1);
    }

    changeColor(state = 0) {
        if (state === 0) {
            let label = this.parent.getElementsByClassName('labelTemp')
            for (let i = 0; i < label.length; i++)
                label[i].style.color = this.offColor;
        }
        if (state === 1) {
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
        // let TimeLabel = this.TimeLabel;
        // let updateTimeLabel = this.updateTimeLabel;
        let field = this.getField();
        let tableName = this.tableName;
        let unit_id = this.unit_id;
        let substation_id = this.substation_id;

        $.ajax({
            url: this.apiUrl,
            type: 'post',
            dataType: 'json',
            data: {
                'unit_id': unit_id,
                'substation_id': substation_id,
                'field': field,
                'tableName': tableName,
            },
            success: function (result) {
                label1.innerHTML = result[0];
                label2.innerHTML = result[1];
                label3.innerHTML = result[2];
                // TimeLabel.innerHTML       = 'last data time :' + result[3];
                // updateTimeLabel.innerHTML = 'update time :' + result[4];
                loadDiv.style.display = "none"
            }
        });
    }

    getField() {
        let pageIndex = this.getPageIndex()
        switch (this.sectionIndex) {
            case 1:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Voltage_A_N,1)', 'ROUND(Voltage_B_N,1)', 'ROUND(Voltage_C_N,1)'];

                    case 2:
                        return ['ROUND(Voltage_A_B,1)', 'ROUND(Voltage_B_C,1)', 'ROUND(Voltage_C_A,1)'];

                    case 3:
                        return ['ROUND(Current_A,1)', 'ROUND(Current_B,1)', 'ROUND(Current_C,1)'];

                    case 4:
                        return ['ROUND(Apparent_Power_A,1)', 'ROUND(Apparent_Power_B,1)', 'ROUND(Apparent_Power_C,1)'];

                    case 5:
                        return ['ROUND(Active_Power_A,1)', 'ROUND(Active_Power_B,1)', 'ROUND(Active_Power_C,1)'];

                    case 6:
                        return ['ROUND(Reactive_Power_A,1)', 'ROUND(Reactive_Power_B,1)', 'ROUND(Reactive_Power_C,1)'];

                    case 7:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];

                    case 8:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_C,1)', 'ROUND(Voltage_B_N,1)'];

                    case 9:
                        return ['ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)', 'ROUND(Current_A,1)'];
                    default:
                        return null;
                }

            case 2:
                switch (pageIndex) {
                    case 1:
                        return [null, null, 'ROUND(Active_Energy_Delivered_Into_Load,1)'];


                    case 2:
                        return [null, null, 'ROUND(Apparent_Energy_Delivered,1)'];

                    case 3:
                        return [null, null, 'ROUND(Reactive_Energy_Delivered,1)'];

                    case 4:
                        return [null, null, 'ROUND(Active_Energy_Received_Out_of_Load,1)'];

                    case 5:
                        return [null, null, 'ROUND(Reactive_Energy_Received,1)'];

                    case 6:
                        return [null, null, 'ROUND(Apparent_Energy_Received,1)'];
                    default:
                        return null;

                }


            case 3:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Apparent_Power_Total,1)', 'ROUND(Reactive_Power_Total,1)', 'ROUND(Active_Power_Total,1)'];

                    case 2:
                        return ['ROUND(Current_Avg,1)', 'ROUND(Reactive_Power_Total,1)', 'ROUND(Active_Power_Total,1)'];
                    default:
                        return null;
                }


            case 4:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Reactive_Power_Total,1)'];
                    default:
                        return null;
                }


            case 5:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Reactive_Energy_Delivered_Neg_Received,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];
                    default:
                        return null;
                }


            case 6:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Active_Energy_Delivered_Neg_Received,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];
                    default:
                        return null;
                }


            case 7:
                switch (pageIndex) {
                    case 1:
                        return ['DATE_FORMAT(JStart_time, "%Y")', 'DATE_FORMAT(JStart_time, "%m.%d")', 'DATE_FORMAT(Start_time, "%H.%i")'];
                    default:
                        return null;
                }


            case 8:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Current_Avg,1)', 'ROUND(Power_Factor_Total,1)', 'ROUND(Voltage_L_N_Avg,1)'];

                    case 2:
                        return ['ROUND(Apparent_Power_Total,1)', 'ROUND(Reactive_Power_Total,1)', 'ROUND(Active_Power_Total,1)'];

                    case 3:
                        return ['ROUND(Frequency,1)', 'ROUND(Current_Unbalance_Worst,1)', 'ROUND(Power_Factor_C,1)'];
                    default:
                        return null;

                }


            default:
                return null;
        }

    }
}

class Schneider_PM2200 extends Schneider_PM21xx {
    constructor(id, substation_id, unit_id, unit_name, themeUrl, apiUrl) {
        super(id, substation_id, unit_id, 2, unit_name, "Schneider_PM2200", "Schneider_PM2200", themeUrl, apiUrl);
        this.label1 = this.parent.getElementsByClassName('showLabel1 valueLabel')[0];
        this.label2 = this.parent.getElementsByClassName('showLabel2 valueLabel')[0];
        this.label3 = this.parent.getElementsByClassName('showLabel3 valueLabel')[0];
        this.label4 = this.parent.getElementsByClassName('showLabel4 valueLabel')[0];
        this.apiUrl = apiUrl + "device/data";
        this.type = "Schneider_PM2200";
        this.type_Id = 2;
        this.tableName = "elecsub_data";

        this.pageIndex = [1, 1, 2, 2, 2, 2, 1, 1];
        this.minPageIndex = [1, 1, 2, 2, 2, 2, 1, 1];
        this.maxPageIndex = [9, 6, 2, 2, 2, 2, 1, 3];
        this.sectionIndex = 1;
        this.minSectionIndex = 1;
        this.maxSectionIndex = 8;
        this.html = "";
        this.setData();
    }

    setData() {
        this.loadDiv.style.display = ""
        this.label1.innerHTML = "";
        this.label2.innerHTML = "";
        this.label3.innerHTML = "";
        this.label4.innerHTML = "";

        let label1 = this.label1;
        let label2 = this.label2;
        let label3 = this.label3;
        let label4 = this.label4;
        let loadDiv = this.loadDiv;
        // let TimeLabel = this.TimeLabel;
        // let updateTimeLabel = this.updateTimeLabel;
        let field = this.getField();
        let tableName = this.tableName;
        let unit_id = this.unit_id;
        let substation_id = this.substation_id;

        $.ajax({
            url: this.apiUrl,
            type: 'post',
            dataType: 'json',
            data: {
                'unit_id': unit_id,
                'substation_id': substation_id,
                'field': field,
                'tableName': tableName,
            },
            success: function (result) {
                label1.innerHTML = result[0];
                label2.innerHTML = result[1];
                label3.innerHTML = result[2];
                label4.innerHTML = result[2];
                loadDiv.style.display = "none"
            }
        });
    }

    getField() {
        let pageIndex = this.getPageIndex()
        switch (this.sectionIndex) {
            case 1:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Voltage_A_N,1)', 'ROUND(Voltage_B_N,1)', 'ROUND(Voltage_C_N,1)'];

                    case 2:
                        return ['ROUND(Voltage_A_B,1)', 'ROUND(Voltage_B_C,1)', 'ROUND(Voltage_C_A,1)'];

                    case 3:
                        return ['ROUND(Current_A,1)', 'ROUND(Current_B,1)', 'ROUND(Current_C,1)'];

                    case 4:
                        return ['ROUND(Apparent_Power_A,1)', 'ROUND(Apparent_Power_B,1)', 'ROUND(Apparent_Power_C,1)'];

                    case 5:
                        return ['ROUND(Active_Power_A,1)', 'ROUND(Active_Power_B,1)', 'ROUND(Active_Power_C,1)'];

                    case 6:
                        return ['ROUND(Reactive_Power_A,1)', 'ROUND(Reactive_Power_B,1)', 'ROUND(Reactive_Power_C,1)'];

                    case 7:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];

                    case 8:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_C,1)', 'ROUND(Voltage_B_N,1)'];

                    case 9:
                        return ['ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)', 'ROUND(Current_A,1)'];
                    default:
                        return null;
                }

            case 2:
                switch (pageIndex) {
                    case 1:
                        return [null, null, 'ROUND(Active_Energy_Delivered_Into_Load,1)'];


                    case 2:
                        return [null, null, 'ROUND(Apparent_Energy_Delivered,1)'];

                    case 3:
                        return [null, null, 'ROUND(Reactive_Energy_Delivered,1)'];

                    case 4:
                        return [null, null, 'ROUND(Active_Energy_Received_Out_of_Load,1)'];

                    case 5:
                        return [null, null, 'ROUND(Reactive_Energy_Received,1)'];

                    case 6:
                        return [null, null, 'ROUND(Apparent_Energy_Received,1)'];
                    default:
                        return null;

                }


            case 3:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Apparent_Power_Total,1)', 'ROUND(Reactive_Power_Total,1)', 'ROUND(Active_Power_Total,1)'];

                    case 2:
                        return ['ROUND(Current_Avg,1)', 'ROUND(Reactive_Power_Total,1)', 'ROUND(Active_Power_Total,1)'];
                    default:
                        return null;
                }


            case 4:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Reactive_Power_Total,1)'];
                    default:
                        return null;
                }


            case 5:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Reactive_Energy_Delivered_Neg_Received,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];
                    default:
                        return null;
                }


            case 6:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Active_Energy_Delivered_Neg_Received,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];

                    case 2:
                        return ['ROUND(Power_Factor_A,1)', 'ROUND(Power_Factor_B,1)', 'ROUND(Power_Factor_C,1)'];
                    default:
                        return null;
                }


            case 7:
                switch (pageIndex) {
                    case 1:
                        return ['DATE_FORMAT(JStart_time, "%Y")', 'DATE_FORMAT(JStart_time, "%m.%d")', 'DATE_FORMAT(Start_time, "%H.%i")'];
                    default:
                        return null;
                }


            case 8:
                switch (pageIndex) {
                    case 1:
                        return ['ROUND(Current_Avg,1)', 'ROUND(Power_Factor_Total,1)', 'ROUND(Voltage_L_N_Avg,1)'];

                    case 2:
                        return ['ROUND(Apparent_Power_Total,1)', 'ROUND(Reactive_Power_Total,1)', 'ROUND(Active_Power_Total,1)'];

                    case 3:
                        return ['ROUND(Frequency,1)', 'ROUND(Current_Unbalance_Worst,1)', 'ROUND(Power_Factor_C,1)'];
                    default:
                        return null;

                }


            default:
                return null;
        }

    }

    f1(){
        console.log("f1")
    }
    f2(){
        console.log("f2")
    }
    f3(){
        console.log("f3")
    }
    f4(){
        console.log("f4")
    }
}

function type_chooser(deviceType, id, substation_id, unitId, unitName, themeUrl, urlApi) {
    switch (deviceType) {
        case 1:
            return new Schneider_PM2100(id, substation_id, unitId, unitName, themeUrl, urlApi);
        case 2:
            return new Schneider_PM2200(id, substation_id, unitId, unitName, themeUrl, urlApi);
        default:
            return null;
    }
}

function getHtml(deviceType, index) {
    let tempHtml;
    let regExp

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
    
    regExp = /%index/g;
    tempHtml = tempHtml.replace(regExp, index);
    regExp = /%caret_size/g;
    tempHtml = tempHtml.replace(regExp, caret_size);
    return tempHtml
}


function Schneider_PM2100_HTML() {
    return (
        `<div class="parent" id="Schneider_PM2100_%index" style="margin: auto"> 
            <div class="row" style="position: relative;width: 420px;height: 425px;margin: auto!important;">
                <div style="position: relative;width: 80px;height: 425px;"> 
                    <i class="fa fa-caret-right labelTemp label1  section8" aria-hidden="true" 
                       style="position: absolute;left: 1px;top: 50px; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label2  section8 section3 section4 section5 section6" 
                       aria-hidden="true" 
                       style="left: 1px;top: 74px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label3 section8" aria-hidden="true" 
                       style="left: 1px;top: 98px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label4 section8" aria-hidden="true" 
                       style="left: 1px;top: 122px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label1  section8" aria-hidden="true" 
                       style="left: 1px;top: 146px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label2  section8 section3 section4 section5 section6" 
                       aria-hidden="true" 
                       style="left: 1px;top: 170px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label3  section8" aria-hidden="true" 
                       style="left: 1px;top: 194px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label3  section8" aria-hidden="true" 
                       style="left: 1px;top: 218px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label1  section8" aria-hidden="true" 
                       style="left: 1px;top: 242px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label2 section8 section3 section4 section5 section6" 
                       aria-hidden="true" 
                       style="left: 1px;top: 266px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label3  section8" aria-hidden="true" 
                       style="left: 1px;top: 290px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
        
                    <i class="fa fa-caret-right labelTemp label4  section8" aria-hidden="true" 
                       style="left: 1px;top: 314px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
                </div> 
                <div style="position: relative;width: 260px;height: 425px;"> 
                    <div style="position: relative;width: 260px;height: 279px;margin: auto!important;top: 52px;"> 
                        <div class="load" style="margin: auto;"> 
                           <div class="gear one"> 
                               <svg id="blue" viewBox="0 0 100 100" fill="#94DDFF"> 
                                           <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6              c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3              l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9              c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path> 
                                 </svg> 
                           </div> 
                           <div class="gear two"> 
                               <svg id="pink" viewBox="0 0 100 100" fill="#FB8BB9"> 
                                   <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6              c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3              l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9              c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path> 
                               </svg> 
                           </div> 
                           <div class="gear three"> 
                               <svg id="yellow" viewBox="0 0 100 100" fill="#FFCD5C"> 
                                   <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6              c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3              l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9              c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path> 
                               </svg> 
                           </div> 
                        </div> 
                        <div class="row text-center" style="height: 93px;margin: auto!important;"> 
                            <label class="text-center showLabel1" 
                                   style="font-size: 64px; color : #ff0000;margin: auto!important;"></label> 
                        </div> 
                        <div class="row text-center" style="height: 93px;margin: auto!important;"> 
                            <label class="text-center showLabel2" 
                                   style="font-size: 64px; color : #ff0000;margin: auto!important;"></label>
                        </div> 
                        <div class="row text-center" style="height: 93px;margin: auto!important;">
                            <label class="text-center showLabel3" 
                                   style="font-size: 64px; color : #ff0000;margin: auto!important;"></label>
                        </div> 
                    </div> 
                    <div class="row" style="position:relative;top: 52px;"> 
                        <div style="width: 260px; margin: auto;height: 50px;">
                            <i class="fa fa-caret-right labelTemp label3 label6  section2" aria-hidden="true" 
                                style="position: absolute; font-size: %caret_sizepx; color : #000000;left: 45px;"></i> 
       
                            <i class="fa fa-caret-right labelTemp label2 label5  section2" aria-hidden="true" 
                               style="position: absolute; font-size: %caret_sizepx; color : #000000;left: 110px;"></i> 
                
                            <i class="fa fa-caret-right labelTemp label1 label4  section2" aria-hidden="true" 
                               style="position: absolute; font-size: %caret_sizepx; color : #000000;left: 180px;"></i> 
                            <button type="button" 
                                style="position:absolute;color: transparent!important;padding: 15px!important;left: 65px;top: 25px;" 
                                class="btn btn-link text-info" id="DownBut">
                                <i style="width: 10px;" onclick="device_class[%index].changeIndex(1)" 
                                    class="fa fa-eye-slash"></i>
                            </button>
                            <button type="button" 
                                    style="position:absolute;color: transparent!important;padding: 15px!important;left: 130px;top: 25px;" 
                                    class="btn btn-link text-info" id="UPButt"><i 
                                    style="width: 10px;" 
                                    onclick="device_class[%index].changeIndex(-1)" 
                                    class="fa fa-eye-slash"></i>
                            </button>
                            <button type="button" 
                                    style="position:absolute;color: transparent!important;padding: 15px!important;left: 185px;top: 25px;" 
                                    class="btn btn-link text-info" id="OkBut">
                                    <i style="width: 10px;" onclick="device_class[%index].changeSection()" 
                                       class="fa fa-eye-slash"></i>
                            </button> 

                        </div> 
                    </div> 
                </div> 
                <div style="position: relative;width: 80px;height: 425px;"> 
                    <i class="fa fa-caret-left labelTemp label1 section1" aria-hidden="true" 
                       style="right: 6px;top: 54px;position: absolute; font-size: %caret_sizepx; color : #ff0000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label2 section1" aria-hidden="true" 
                       style="right: 6px;top: 78px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label3 section1" aria-hidden="true" 
                       style="right: 6px;top: 102px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label4  section1" aria-hidden="true" 
                       style="right: 6px;top: 126px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label5 section1" aria-hidden="true" 
                       style="right: 6px;top: 150px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label6 section1" aria-hidden="true" 
                       style="right: 6px;top: 174px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label7 section1" aria-hidden="true" 
                       style="right: 6px;top: 200px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label8 section1" aria-hidden="true" 
                       style="right: 6px;top: 222px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label9 section1" aria-hidden="true" 
                       style="right: 6px;top: 246px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label2 section3" aria-hidden="true" 
                       style="right: 6px;top: 275px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label2 section4" aria-hidden="true" 
                       style="right: 6px;top: 299px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label2 section5" aria-hidden="true" 
                       style="right: 6px;top: 323px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label2 section6" aria-hidden="true" 
                       style="right: 6px;top: 347px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
    
                    <i class="fa fa-caret-left labelTemp label1 section7" aria-hidden="true" 
                       style="right: 6px;top: 373px;position: absolute; font-size: %caret_sizepx; color : #000000;"></i> 
                </div> 
            </div>
        </div>`
    )

}

function Schneider_PM2200_HTML() {
    return (
        `<div class="parent" id="Schneider_PM2200_%index" style="margin: auto"> 
            <div class="row" style="position: relative;width: 420px;height: 425px;margin: auto!important;">
                <div style="position: relative;width: 80px;height: 425px;"> 
                </div> 
                <div style="position: relative;width: 260px;height: 425px;"> 
                    <div style="position: relative;width: 256px;height: 236px;margin: auto!important;top: 87px;"> 
                        <div class="load" style="margin: auto;"> 
                           <div class="gear one"> 
                               <svg id="blue" viewBox="0 0 100 100" fill="#94DDFF"> 
                                           <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6              c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3              l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9              c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path> 
                                 </svg> 
                           </div> 
                           <div class="gear two"> 
                               <svg id="pink" viewBox="0 0 100 100" fill="#FB8BB9"> 
                                   <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6              c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3              l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9              c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path> 
                               </svg> 
                           </div> 
                           <div class="gear three"> 
                               <svg id="yellow" viewBox="0 0 100 100" fill="#FFCD5C"> 
                                   <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6              c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3              l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9              c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path> 
                               </svg> 
                           </div> 
                        </div> 
                        <div class="row text-center" style="height: 32px;margin: auto!important;border-bottom: 2px solid #0c2920;"> 
                            <label class="text-center topHeader" 
                                   style="font-size: 18px; color : white;margin: auto!important;width: 200px;background-color: #3e454b;margin-bottom: unset!important;">Summery</label> 
                        </div> 
                        
                        <div class="row text-center" style="height: 44px;margin: auto!important;">
                            <label class="text-center showLabel1 unitLabel" 
                                    style="font-size: 18px; color : #2a2f35;width: 64px;margin: auto!important;"></label>
                            <label class="text-center showLabel1 valueLabel" 
                                    style="font-size: 32px; color : #2a2f35;width: 128px;margin: auto!important;"></label> 
                            <label class="text-center showLabel1 desLabel" 
                                    style="font-size: 14px; color : #2a2f35;width: 64px;margin: auto!important;"></label>
                        </div> 
                        <div class="row text-center" style="height: 44px;margin: auto!important;">
                            <label class="text-center showLabel2 unitLabel" 
                                    style="font-size: 18px; color : #2a2f35;width: 64px;margin: auto!important;"></label>
                            <label class="text-center showLabel2 valueLabel" 
                                    style="font-size: 32px; color : #2a2f35;width: 128px;margin: auto!important;"></label> 
                            <label class="text-center showLabel2 desLabel" 
                                    style="font-size: 14px; color : #2a2f35;width: 64px;margin: auto!important;"></label>
                        </div> 
                        <div class="row text-center" style="height: 44px;margin: auto!important;">
                            <label class="text-center showLabel3 unitLabel" 
                                    style="font-size: 18px; color : #2a2f35;width: 64px;margin: auto!important;"></label>
                            <label class="text-center showLabel3 valueLabel" 
                                    style="font-size: 32px; color : #2a2f35;width: 128px;margin: auto!important;"></label> 
                            <label class="text-center showLabel3 desLabel" 
                                    style="font-size: 14px; color : #2a2f35;width: 64px;margin: auto!important;"></label>
                        </div> 
                        <div class="row text-center" style="height: 44px;margin: auto!important;">
                            <label class="text-center showLabel4 unitLabel" 
                                    style="font-size: 18px; color : #2a2f35;width: 64px;margin: auto!important;"></label>
                            <label class="text-center showLabel4 valueLabel" 
                                    style="font-size: 32px; color : #2a2f35;width: 128px;margin: auto!important;"></label> 
                            <label class="text-center showLabel4 desLabel" 
                                    style="font-size: 14px; color : #2a2f35;width: 64px;margin: auto!important;"></label>
                        </div> 
                      
                        <div class="row text-center" style="height: 28px;margin: auto!important;border-bottom: 2px solid #0c2920;"> 
                            <label class="text-center bottomFooter1" 
                                    style="position: absolute;left: 10px;font-size: 18px; color : #2a2f35;width: 50px;margin-top: unset!important;">I</label> 
                            <label class="text-center bottomFooter2" 
                                    style="position: absolute;left: 70px;font-size: 18px; color : #2a2f35;width: 50px;margin-top: unset!important;">V-V</label> 
                            <label class="text-center bottomFooter3" 
                                    style="position: absolute;left: 130px;font-size: 18px; color : #2a2f35;width: 50px;margin-top: unset!important;">PQS</label> 
                            <label class="text-center bottomFooter4" 
                                    style="position: absolute;left: 190px;font-size: 18px; color : #2a2f35;width: 50px;margin-top: unset!important;">right</label>
                        </div> 
                    </div> 
                    <div class="row" style="position:relative;top: 92px;"> 
                        <div style="width: 260px; margin: auto;height: 50px;">
                            <button type="button" 
                                style="position:absolute;color: transparent!important;padding: 15px!important;left: 32px;" 
                                class="btn btn-link text-info" id="DownBut">
                                <i style="width: 10px;" onclick="device_class[%index].f1()" 
                                    class="fa fa-eye-slash"></i>
                            </button>
                            <button type="button" 
                                    style="position:absolute;color: transparent!important;padding: 15px!important;left: 93px;" 
                                    class="btn btn-link text-info" id="UPButt"><i 
                                    style="width: 10px;" 
                                    onclick="device_class[%index].f2()" 
                                    class="fa fa-eye-slash"></i>
                            </button>
                            <button type="button" 
                                    style="position:absolute;color: transparent!important;padding: 15px!important;left: 153px;" 
                                    class="btn btn-link text-info" id="OkBut">
                                    <i style="width: 10px;" onclick="device_class[%index].f3()" 
                                       class="fa fa-eye-slash"></i>
                            </button> 
                            <button type="button" 
                                    style="position:absolute;color: transparent!important;padding: 15px!important;left: 213px;" 
                                    class="btn btn-link text-info" id="OkBut">
                                    <i style="width: 10px;" onclick="device_class[%index].f4()" 
                                       class="fa fa-eye-slash"></i>
                            </button> 

                        </div> 
                    </div> 
                </div> 
                <div style="position: relative;width: 80px;height: 425px;"> 
                </div> 
            </div>
        </div>`
    )
}
