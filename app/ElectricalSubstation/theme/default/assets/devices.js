const caret_size = 30
const showField = 0
const goToChild = 1
const goToParentChild = 2
const goUp = 3
const goRight = 4

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

        this.apiUrl = apiUrl + "device/data";
        this.tableName = "elecsub_data";
        this.loadDiv = this.parent.getElementsByClassName('load')[0];
        this.label1 = this.parent.getElementsByClassName('showLabel1')[0];
        this.label2 = this.parent.getElementsByClassName('showLabel2')[0];
        this.label3 = this.parent.getElementsByClassName('showLabel3')[0];
        this.TimeLabel = this.parent.getElementsByClassName('TimeLabel')[0];
        this.updateTimeLabel = this.parent.getElementsByClassName('updateTimeLabel')[0];
        this.html = "";
        this.menu = new Menu();
        this.setHtml(id);
    }

    changeChild(change = 1) {
        this.menu.nextChild(0, change);

        this.setData();
    }

    childChildByNumber(number = 0) {
        console.log(number)
        this.menu.childChildByNumber(number);
        this.setData();
    }

    changeParent(change = 1) {
        this.menu.nextChild(1, change);

        this.setData();
    }

    setData() {
    }

    getField() {
        return this.menu.activeChild.field;
    }

    getAction() {
        return this.menu.activeChild.action;
    }

    getDownField() {
        let start = this.menu.activeChild.downFieldIndex;
        let end = start + this.menu.showfieldCount;

        return this.menu.activeChild.downfield.slice(start, end);
    }

    getUnitField() {
        return this.menu.activeChild.unit;
    }

    getDescriptionField() {
        return this.menu.activeChild.description;
    }

    getHeaderField() {
        return this.menu.activeChild.header;
    }

    setDownField(label, field = "") {
        if (field.includes("action_up")) {
            label.innerHTML = `<i class="fa fa-caret-up" aria-hidden="true"></i>`;
        } else if (field.includes("action_right")) {
            label.innerHTML = `<i class="fa fa-caret-right" aria-hidden="true"></i>`;
        } else {
            label.innerHTML = field;
        }
    }

    setField(label, field) {
        if (field < 10000)
            label.innerHTML = field;
        else {
            label.innerHTML = Math.round(field);
        }
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

        this.type = "Schneider_PM2100";
        this.type_Id = 1;

        this.offColor = offColor;
        this.onColor = onColor;

        this.createMenu();

        this.setData();
    }

    changeColor(state = 0) {
        if (state === 0) {
            let label = this.parent.getElementsByClassName('labelTemp')
            for (let i = 0; i < label.length; i++)
                label[i].style.color = this.offColor;
        }
        if (state === 1) {
            let child = this.menu.getChild();
            let parent = this.menu.getChild(1);
            let label = this.parent.getElementsByClassName('label' + child.id + ' section' + parent.id)
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
        let field = this.getField();
        let tableName = this.tableName;
        let unit_id = this.unit_id;
        let substation_id = this.substation_id;
        let setField = this.setField;

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
                setField(label1, result[0]);
                setField(label2, result[1]);
                setField(label3, result[2]);
                loadDiv.style.display = "none"
            }
        });
    }

    changeChild(change = 1) {
        this.changeColor();
        super.changeChild(change)
        this.changeColor(1);
    }

    changeParent(change = 1) {
        this.changeColor();
        super.changeParent(change)
        this.changeColor(1);
    }

    f1() {
        this.changeChild()
    }

    f2() {
        this.changeChild(-1)
    }

    f3() {
        this.changeParent()
    }

    createMenu() {
        this.menu = new Menu(this.id, "Schneider_PM2100_" + this.id);

        this.menu.addChild(null, 1, "section1")
        this.menu.addChild(null, 2, "section2")
        this.menu.addChild(null, 3, "section3")
        this.menu.addChild(null, 4, "section4")
        this.menu.addChild(null, 5, "section5")
        this.menu.addChild(null, 6, "section6")
        this.menu.addChild(null, 7, "section7")
        this.menu.addChild(null, 8, "section8")

        this.menu.addChild("section1", 1, "index 1", showField, ['ROUND(Voltage_A_N,2)', 'ROUND(Voltage_B_N,2)', 'ROUND(Voltage_C_N,2)'])
        this.menu.addChild("section1", 2, "index 2", showField, ['ROUND(Voltage_A_B,2)', 'ROUND(Voltage_B_C,2)', 'ROUND(Voltage_C_A,2)'])
        this.menu.addChild("section1", 3, "index 3", showField, ['ROUND(Current_A,2)', 'ROUND(Current_B,2)', 'ROUND(Current_C,2)'])
        this.menu.addChild("section1", 4, "index 4", showField, ['ROUND(Apparent_Power_A,2)', 'ROUND(Apparent_Power_B,2)', 'ROUND(Apparent_Power_C,2)'])
        this.menu.addChild("section1", 5, "index 5", showField, ['ROUND(Active_Power_A,2)', 'ROUND(Active_Power_B,2)', 'ROUND(Active_Power_C,2)'])
        this.menu.addChild("section1", 6, "index 6", showField, ['ROUND(Reactive_Power_A,2)', 'ROUND(Reactive_Power_B,2)', 'ROUND(Reactive_Power_C,2)'])
        this.menu.addChild("section1", 7, "index 7", showField, ['ROUND(Power_Factor_A,2)', 'ROUND(Power_Factor_B,2)', 'ROUND(Power_Factor_C,2)'])
        this.menu.addChild("section1", 8, "index 8", showField, ['0', '0', '0'])
        this.menu.addChild("section1", 9, "index 9", showField, ['0', '0', '0'])

        this.menu.addChild("section2", 1, "index 1", showField, [null, null, 'ROUND(Active_Energy_Delivered,2)'])
        this.menu.addChild("section2", 2, "index 2", showField, [null, null, 'ROUND(Apparent_Energy_Delivered,2)'])
        this.menu.addChild("section2", 3, "index 3", showField, [null, null, 'ROUND(Reactive_Energy_Delivered,2)'])
        this.menu.addChild("section2", 4, "index 4", showField, [null, null, 'ROUND(Active_Energy_Received,2)'])
        this.menu.addChild("section2", 5, "index 5", showField, [null, null, 'ROUND(Reactive_Energy_Received,2)'])
        this.menu.addChild("section2", 6, "index 6", showField, [null, null, 'ROUND(Apparent_Energy_Received,2)'])

        this.menu.addChild("section3", 2, "index 2", showField, ['ROUND(Apparent_Power_Last_Demand,2)', 'ROUND(Active_Power_Last_Demand,2)', 'ROUND(Reactive_Power_Last_Demand,2)'])

        this.menu.addChild("section4", 2, "index 2", showField, ['ROUND(Apparent_Power_Present_Demand,2)', 'ROUND(Active_Power_Present_Demand,2)', 'ROUND(Reactive_Power_Present_Demand,2)'])

        this.menu.addChild("section5", 2, "index 2", showField, ['ROUND(Apparent_Power_Predicted_Demand,2)', 'ROUND(Active_Power_Predicted_Demand,2)', 'ROUND(Reactive_Power_Predicted_Demand,2)'])

        this.menu.addChild("section6", 2, "index 2", showField, ['ROUND(Apparent_Power_Peak_Demand,2)', 'ROUND(Active_Power_Peak_Demand,2)', 'ROUND(Reactive_Power_Peak_Demand,2)'])

        this.menu.addChild("section7", 1, "index 1", showField, ['DATE_FORMAT(JStart_time, "%Y")', 'DATE_FORMAT(JStart_time, "%m.%d")', 'DATE_FORMAT(Start_time, "%H.%i")'])

        this.menu.addChild("section8", 1, "index 1", showField, ['ROUND(Voltage_L_N_Avg,2)', 'ROUND(Current_Avg,2)', 'ROUND(Power_Factor_Total,2)'])
        this.menu.addChild("section8", 2, "index 2", showField, ['ROUND(Apparent_Power_Total,2)', 'ROUND(Reactive_Power_Total,2)', 'ROUND(Active_Power_Total,2)'])
        this.menu.addChild("section8", 3, "index 3", showField, ['ROUND(Frequency,2)', 'ROUND(Current_N,2)', 'ROUND(0,2)'])

        this.menu.showfieldCount = 3;
        this.menu.activeChildPath = [0, 0];
        this.menu.updateChild();
    }
}

class Schneider_PM2200 extends Schneider_PM21xx {
    constructor(id, substation_id, unit_id, unit_name, themeUrl, apiUrl) {
        super(id, substation_id, unit_id, 2, unit_name, "Schneider_PM2200", "Schneider_PM2200", themeUrl, apiUrl);
        this.label1 = this.parent.getElementsByClassName('showLabel1 valueLabel')[0];
        this.label2 = this.parent.getElementsByClassName('showLabel2 valueLabel')[0];
        this.label3 = this.parent.getElementsByClassName('showLabel3 valueLabel')[0];
        this.label4 = this.parent.getElementsByClassName('showLabel4 valueLabel')[0];

        this.unitlabel1 = this.parent.getElementsByClassName('showLabel1 unitLabel')[0];
        this.unitlabel2 = this.parent.getElementsByClassName('showLabel2 unitLabel')[0];
        this.unitlabel3 = this.parent.getElementsByClassName('showLabel3 unitLabel')[0];
        this.unitlabel4 = this.parent.getElementsByClassName('showLabel4 unitLabel')[0];

        this.deslabel1 = this.parent.getElementsByClassName('showLabel1 desLabel')[0];
        this.deslabel2 = this.parent.getElementsByClassName('showLabel2 desLabel')[0];
        this.deslabel3 = this.parent.getElementsByClassName('showLabel3 desLabel')[0];
        this.deslabel4 = this.parent.getElementsByClassName('showLabel4 desLabel')[0];

        this.bottomFooter1 = this.parent.getElementsByClassName('bottomFooter1')[0];
        this.bottomFooter2 = this.parent.getElementsByClassName('bottomFooter2')[0];
        this.bottomFooter3 = this.parent.getElementsByClassName('bottomFooter3')[0];
        this.bottomFooter4 = this.parent.getElementsByClassName('bottomFooter4')[0];

        this.topHeader = this.parent.getElementsByClassName('topHeader')[0];

        this.type = "Schneider_PM2200";
        this.type_Id = 2;

        this.createMenu();

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

        this.unitlabel1.innerHTML = "";
        this.unitlabel2.innerHTML = "";
        this.unitlabel3.innerHTML = "";
        this.unitlabel4.innerHTML = "";

        let unitlabel1 = this.unitlabel1;
        let unitlabel2 = this.unitlabel2;
        let unitlabel3 = this.unitlabel3;
        let unitlabel4 = this.unitlabel4;

        this.deslabel1.innerHTML = "";
        this.deslabel2.innerHTML = "";
        this.deslabel3.innerHTML = "";
        this.deslabel4.innerHTML = "";

        let deslabel1 = this.deslabel1;
        let deslabel2 = this.deslabel2;
        let deslabel3 = this.deslabel3;
        let deslabel4 = this.deslabel4;

        this.bottomFooter1.innerHTML = "";
        this.bottomFooter2.innerHTML = "";
        this.bottomFooter3.innerHTML = "";
        this.bottomFooter4.innerHTML = "";

        let bottomFooter1 = this.bottomFooter1;
        let bottomFooter2 = this.bottomFooter2;
        let bottomFooter3 = this.bottomFooter3;
        let bottomFooter4 = this.bottomFooter4;


        this.topHeader.innerHTML = "";
        let topHeader = this.topHeader;

        let loadDiv = this.loadDiv;

        this.menu.HandleAction();

        let field = this.getField();
        let downField = this.getDownField();
        let description = this.getDescriptionField();
        let unit = this.getUnitField();
        let header = this.getHeaderField();
        let tableName = this.tableName;
        let unit_id = this.unit_id;
        let substation_id = this.substation_id;
        let setDownField = this.setDownField;
        let setField = this.setField;

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
                setField(label1, result[0]);
                setField(label2, result[1]);
                setField(label3, result[2]);
                setField(label4, result[3]);

                unitlabel1.innerHTML = unit[0];
                unitlabel2.innerHTML = unit[1];
                unitlabel3.innerHTML = unit[2];
                unitlabel4.innerHTML = unit[3];

                deslabel1.innerHTML = description[0];
                deslabel2.innerHTML = description[1];
                deslabel3.innerHTML = description[2];
                deslabel4.innerHTML = description[3];

                setDownField(bottomFooter1, downField[0]);
                setDownField(bottomFooter2, downField[1]);
                setDownField(bottomFooter3, downField[2]);
                setDownField(bottomFooter4, downField[3]);

                topHeader.innerHTML = header[0];

                loadDiv.style.display = "none"
            }
        });
    }

    f1() {
        this.childChildByNumber(this.menu.activeChild.downFieldIndex + 0)
    }

    f2() {
        this.childChildByNumber(this.menu.activeChild.downFieldIndex + 1)
    }

    f3() {
        this.childChildByNumber(this.menu.activeChild.downFieldIndex + 2)
    }

    f4() {
        this.childChildByNumber(this.menu.activeChild.downFieldIndex + 3)
    }

    createMenu() {
        this.menu = new Menu(this.id, "Schneider_PM2200_" + this.id);
        this.menu.addChild(null, 1, "summery", [showField], ['ROUND(Voltage_L_N_Avg,2)', 'ROUND(Current_Avg,2)', 'ROUND(Active_Power_Total,2)', 'ROUND(Active_Energy_Delivered/1000,2)'], ['I', 'V-v', 'PQS', 'action_right', 'E', 'PF', 'F', 'action_right'], ['V', 'A', 'kW', 'MWh'], ['Vavg', 'Iavg', 'Ptot', 'E Del'], ['Summery'])

        this.menu.addChild("summery", 0, "I", [goToChild, 0])

        this.menu.addChild("I", 0, "I_I_Child", [showField], ['ROUND(Current_A,2)', 'ROUND(Current_B,2)', 'ROUND(Current_C,2)', 'ROUND(Current_N,2)'], ['action_up', 'I', 'Dmd', ''], ['A', 'A', 'A', 'A'], ['I1', 'I2', 'I3', 'In'], ['Amps Per Phases'])
        this.menu.addChild("I_I_Child", 0, "I_action_up", [goUp, 3])
        this.menu.addChild("I_I_Child", 1, "I_I_Avg_Child", [goToParentChild, 0])
        this.menu.addChild("I_I_Child", 2, "I_Dmd_Child", [goToParentChild, 1])

        this.menu.addChild("I", 1, "I_Dmd", [goToChild, 0])

        this.menu.addChild("I_Dmd", 0, "I_Dmd_I_Avg", [showField], ['ROUND(Current_Avg_Present_Demand,2)', 'ROUND(Current_Avg_Last_Demand,2)', 'ROUND(Current_Avg_Predicted_Demand,2)', 'ROUND(Current_Avg_Peak _Demand,2)'], ['action_up', 'IAvg', 'Pk DT', ''], ['A', 'A', 'A', 'A'], ['Pres', 'Last', 'Pred', 'Peak'], ['Iavg Dmd'])

        this.menu.addChild("I_Dmd_I_Avg", 0, "I_Dmd_I_Avg_action_up", [goUp, 3])
        this.menu.addChild("I_Dmd_I_Avg", 1, "I_Dmd_I_Avg_I_Avg_Child", [goToParentChild, 0])
        this.menu.addChild("I_Dmd_I_Avg", 2, "I_Dmd_I_Avg_Pk_DT_Child", [goToParentChild, 1])

        this.menu.addChild("I_Dmd", 1, "I_Dmd_Pk_DT", [showField], [null, 'DATE_FORMAT(Current_Avg_PK_DT_Demand, "%H:%i:%s")', 'DATE_FORMAT(Current_Avg_PK_DT_Demand, "%m/%d/%y")', null], ['action_up', 'IAvg', 'Pk DT', ''], ['', '', '', ''], ['', '', '', ''], ['Iavg Dmd PkDT'])

        this.menu.addChild("I_Dmd_Pk_DT", 0, "I_Dmd_Pk_DT_action_up", [goUp, 3])
        this.menu.addChild("I_Dmd_Pk_DT", 1, "I_Dmd_Pk_DT_I_Avg_Child", [goToParentChild, 0])
        this.menu.addChild("I_Dmd_Pk_DT", 2, "I_Dmd_Pk_DT_Pk_DT_Child", [goToParentChild, 1])

        this.menu.addChild("summery", 1, "V_v", [goToChild, 0])

        this.menu.addChild("V_v", 0, "V", [showField], ['ROUND(Voltage_A_B,2)', 'ROUND(Voltage_B_C,2)', 'ROUND(Voltage_C_A,2)', null], ['action_up', 'V', 'v', ''], ['V', 'V', 'V', ''], ['V12', 'V23', 'V31', ''], ['V'])

        this.menu.addChild("V", 0, "V_action_up", [goUp, 3])
        this.menu.addChild("V", 1, "V_V_Child", [goToParentChild, 0])
        this.menu.addChild("V", 2, "V_v_Child", [goToParentChild, 1])

        this.menu.addChild("V_v", 0, "v", [showField], ['ROUND(Voltage_A_N,2)', 'ROUND(Voltage_B_N,2)', 'ROUND(Voltage_C_N,2)', null], ['action_up', 'V', 'v', ''], ['V', 'V', 'V', ''], ['V1', 'V2', 'V3', ''], ['v'])

        this.menu.addChild("v", 0, "v_action_up", [goUp, 3])
        this.menu.addChild("v", 1, "v_V_Child", [goToParentChild, 0])
        this.menu.addChild("v", 2, "v_v_Child", [goToParentChild, 1])

        this.menu.addChild("summery", 2, "PQS", [goToChild, 0])

        this.menu.addChild("PQS", 0, "PQS_Child", [showField], ['ROUND(Active_Power_Total,2)', 'ROUND(Reactive_Power_Total,2)', 'ROUND(Apparent_Power_Total,2)', null], ['action_up', 'PQS', 'Phase', 'Dmd'], ['kW', 'KVAR', 'kVA', ''], ['Ptot', 'Qtot', 'Stot', ''], ['Power Summery'])
        this.menu.addChild("PQS_Child", 0, "PQS_action_up", [goUp, 3])
        this.menu.addChild("PQS_Child", 1, "PQS_PQS_Child", [goToParentChild, 0])
        this.menu.addChild("PQS_Child", 2, "PQS_Phase_Child", [goToChild, 0])

        this.menu.addChild("PQS_Phase_Child", 0, "PQS_Phase_P", [showField], ['ROUND(Active_Power_A,2)', 'ROUND(Active_Power_B,2)', 'ROUND(Active_Power_C,2)', 'ROUND(Active_Power_Total,2)'], ['action_up', 'P', 'Q', 'S'], ['kW', 'kW', 'kW', 'kW'], ['P1', 'P2', 'P3', 'Ptot'], ['Active Power'])
        this.menu.addChild("PQS_Phase_P", 0, "PQS_Phase_P_action_up", [goUp, 3])
        this.menu.addChild("PQS_Phase_P", 1, "PQS_Phase_P_P", [goToParentChild, 0])
        this.menu.addChild("PQS_Phase_P", 2, "PQS_Phase_P_Q", [goToParentChild, 1])
        this.menu.addChild("PQS_Phase_P", 3, "PQS_Phase_P_S", [goToParentChild, 2])

        this.menu.addChild("PQS_Phase_Child", 0, "PQS_Phase_Q", [showField], ['ROUND(Reactive_Power_A,2)', 'ROUND(Reactive_Power_B,2)', 'ROUND(Reactive_Power_C,2)', 'ROUND(Reactive_Power_Total,2)'], ['action_up', 'P', 'Q', 'S'], ['KVAR', 'KVAR', 'KVAR', 'KVAR'], ['Q1', 'Q2', 'Q3', 'Qtot'], ['Reactive Power'])
        this.menu.addChild("PQS_Phase_Q", 0, "PQS_Phase_Q_action_up", [goUp, 3])
        this.menu.addChild("PQS_Phase_Q", 1, "PQS_Phase_Q_P", [goToParentChild, 0])
        this.menu.addChild("PQS_Phase_Q", 2, "PQS_Phase_Q_Q", [goToParentChild, 1])
        this.menu.addChild("PQS_Phase_Q", 3, "PQS_Phase_Q_S", [goToParentChild, 2])

        this.menu.addChild("PQS_Phase_Child", 0, "PQS_Phase_S", [showField], ['ROUND(Apparent_Power_A,2)', 'ROUND(Apparent_Power_B,2)', 'ROUND(Apparent_Power_C,2)', 'ROUND(Apparent_Power_Total,2)'], ['action_up', 'P', 'Q', 'S'], ['kVA', 'kVA', 'kVA', 'kVA'], ['S1', 'S2', 'S3', 'Stot'], ['Apparent Power'])
        this.menu.addChild("PQS_Phase_S", 0, "PQS_Phase_S_action_up", [goUp, 3])
        this.menu.addChild("PQS_Phase_S", 1, "PQS_Phase_S_P", [goToParentChild, 0])
        this.menu.addChild("PQS_Phase_S", 2, "PQS_Phase_S_Q", [goToParentChild, 1])
        this.menu.addChild("PQS_Phase_S", 3, "PQS_Phase_S_S", [goToParentChild, 2])


        this.menu.addChild("PQS_Child", 3, "PQS_Dmd_Child", [goToChild, 0])

        this.menu.addChild("PQS_Dmd_Child", 0, "PQS_Dmd_P", [showField], ['ROUND(Active_Power_Last_Demand,2)', 'ROUND(Reactive_Power_Last_Demand,2)', 'ROUND(Apparent_Power_Last_Demand,2)', null], ['action_up', 'Pd', 'Qd', 'Sd'], ['kW', 'kVAR', 'kVA', ''], ['Last', 'Last', 'Last', ''], ['Pwr Dmd Summary'])
        this.menu.addChild("PQS_Dmd_P", 0, "PQS_Dmd_P_action_up", [goUp, 3])
        this.menu.addChild("PQS_Dmd_P", 1, "PQS_Dmd_P_Pd", [goToParentChild, 0])
        this.menu.addChild("PQS_Dmd_P", 2, "PQS_Dmd_P_Qd", [goToParentChild, 1])
        this.menu.addChild("PQS_Dmd_P", 3, "PQS_Dmd_P_Sd", [goToParentChild, 2])

        this.menu.addChild("PQS_Dmd_Child", 1, "PQS_Dmd_Q", [showField], ['ROUND(Active_Power_Last_Demand,2)', 'ROUND(Reactive_Power_Last_Demand,2)', 'ROUND(Apparent_Power_Last_Demand,2)', null], ['action_up', 'Pd', 'Qd', 'Sd'], ['kW', 'kVAR', 'kVA', ''], ['Last', 'Last', 'Last', ''], ['Pwr Dmd Summary'])
        this.menu.addChild("PQS_Dmd_Q", 0, "PQS_Dmd_Q_action_up", [goUp, 3])
        this.menu.addChild("PQS_Dmd_Q", 1, "PQS_Dmd_Q_Pd", [goToParentChild, 0])
        this.menu.addChild("PQS_Dmd_Q", 2, "PQS_Dmd_Q_Qd", [goToParentChild, 1])
        this.menu.addChild("PQS_Dmd_Q", 3, "PQS_Dmd_Q_Sd", [goToParentChild, 2])


        this.menu.addChild("PQS_Dmd_Child", 2, "PQS_Dmd_S", [showField], ['ROUND(Active_Power_Last_Demand,2)', 'ROUND(Reactive_Power_Last_Demand,2)', 'ROUND(Apparent_Power_Last_Demand,2)', null], ['action_up', 'Pd', 'Qd', 'Sd'], ['kW', 'kVAR', 'kVA', ''], ['Last', 'Last', 'Last', ''], ['Pwr Dmd Summary'])
        this.menu.addChild("PQS_Dmd_S", 0, "PQS_Dmd_S_action_up", [goUp, 3])
        this.menu.addChild("PQS_Dmd_S", 1, "PQS_Dmd_S_Pd", [goToParentChild, 0])
        this.menu.addChild("PQS_Dmd_S", 2, "PQS_Dmd_S_Qd", [goToParentChild, 1])
        this.menu.addChild("PQS_Dmd_S", 3, "PQS_Dmd_S_Sd", [goToParentChild, 2])


        this.menu.addChild("summery", 3, "summery_action_right", [goRight, 4])

        this.menu.addChild("summery", 4, "E", [goToChild, 0])

        this.menu.addChild("E", 0, "Wh", [showField], ['ROUND(Active_Energy_Delivered/1000,2)', 'ROUND(Active_Energy_Received/1000,2)', 'ROUND(Active_Energy_Delivered_Pos_Received/1000,2)', 'ROUND(Active_Energy_Delivered_Neg_Received/1000,2)'], ['action_up', 'Wh', 'VAh', 'action_right','action_up', 'VARh', 'Tariff', 'action_right'], ['MWh', 'MWh', 'MWh', 'MWh'], ['Del', 'Rec', 'D+R', 'D-R'], ['Accum Wh'])
        this.menu.addChild("Wh", 0, "E_action_up", [goUp, 3])
        this.menu.addChild("Wh", 1, "E_Wh_Child", [goToParentChild, 0])
        this.menu.addChild("Wh", 2, "E_VAh_Child", [goToParentChild, 1])
        this.menu.addChild("Wh", 3, "E_action_right", [goRight, 4])
        this.menu.addChild("Wh", 4, "E_action_up", [goUp, 3])
        this.menu.addChild("Wh", 5, "E_VARh_Child", [goToParentChild, 2])
        this.menu.addChild("Wh", 6, "E_Tariff_Child", [goToParentChild, 3])
        this.menu.addChild("Wh", 7, "E_action_right", [goRight, 4])

        this.menu.addChild("E", 1, "VAh", [showField], ['ROUND(Apparent_Energy_Delivered/1000,2)', 'ROUND(Apparent_Energy_Received/1000,2)', 'ROUND(Apparent_Energy_Delivered_Pos_Received/1000,2)', 'ROUND(Apparent_Energy_Delivered_Neg_Received/1000,2)'], ['action_up', 'Wh', 'VAh', 'action_right','action_up', 'VARh', 'Tariff', 'action_right'], ['MVAh', 'MVAh', 'MVAh', 'MVAh'], ['Del', 'Rec', 'D+R', 'D-R'], ['Accum VAh'])
        this.menu.addChild("VAh", 0, "E_action_up", [goUp, 3])
        this.menu.addChild("VAh", 1, "E_Wh_Child", [goToParentChild, 0])
        this.menu.addChild("VAh", 2, "E_VAh_Child", [goToParentChild, 1])
        this.menu.addChild("VAh", 3, "E_action_right", [goRight, 4])
        this.menu.addChild("VAh", 4, "E_action_up", [goUp, 3])
        this.menu.addChild("VAh", 5, "E_VARh_Child", [goToParentChild, 2])
        this.menu.addChild("VAh", 6, "E_Tariff_Child", [goToParentChild, 3])
        this.menu.addChild("VAh", 7, "E_action_right", [goRight, 4])

        this.menu.addChild("E", 2, "VARh", [showField], ['ROUND(Reactive_Energy_Delivered/1000,2)', 'ROUND(Reactive_Energy_Received/1000,2)', 'ROUND(Reactive_Energy_Delivered_Pos_Received/1000,2)', 'ROUND(Reactive_Energy_Delivered_Neg_Received/1000,2)'], ['action_up', 'Wh', 'VAh', 'action_right','action_up', 'VARh', 'Tariff', 'action_right'], ['MVAh', 'MVAh', 'MVAh', 'MVAh'], ['Del', 'Rec', 'D+R', 'D-R'], ['Accum VARh'])
        this.menu.addChild("VARh", 0, "E_action_up", [goUp, 3])
        this.menu.addChild("VARh", 1, "E_Wh_Child", [goToParentChild, 0])
        this.menu.addChild("VARh", 2, "E_VAh_Child", [goToParentChild, 1])
        this.menu.addChild("VARh", 3, "E_action_right", [goRight, 4])
        this.menu.addChild("VARh", 4, "E_action_up", [goUp, 3])
        this.menu.addChild("VARh", 5, "E_VARh_Child", [goToParentChild, 2])
        this.menu.addChild("VARh", 6, "E_Tariff_Child", [goToParentChild, 3])
        this.menu.addChild("VARh", 7, "E_action_right", [goRight, 4])

        this.menu.addChild("summery", 5, "PF", [goToChild, 0])
        this.menu.addChild("PF", 0, "PF_True_Child", [showField], ['ROUND(Power_Factor_A,2)', 'ROUND(Power_Factor_B,2)', 'ROUND(Power_Factor_C,2)', 'ROUND(Power_Factor_Total,2)'], ['action_up', 'True', 'Disp', ''], ['Lead', 'Lead', 'Lead', 'Lead'], ['PF a', 'PF b', 'PF c', 'Ptot'], ['True PF'])
        this.menu.addChild("PF_True_Child", 0, "PF_True_action_up", [goUp, 3])
        this.menu.addChild("PF_True_Child", 1, "PF_True_True_Child", [goToParentChild, 0])
        this.menu.addChild("PF_True_Child", 2, "PF_True_Disp_Child", [goToParentChild, 1])

        this.menu.addChild("PF", 0, "PF_Disp_Child", [showField], ['ROUND(Displacement_Power_Factor_A,2)', 'ROUND(Displacement_Power_Factor_B,2)', 'ROUND(Displacement_Power_Factor_C,2)', 'ROUND(Displacement_Power_Factor_Total,2)'], ['action_up', 'True', 'Disp', ''], ['Lead', 'Lead', 'Lead', 'Lead'], ['PF a', 'PF b', 'PF c', 'Ptot'], ['Displacement PF'])
        this.menu.addChild("PF_Disp_Child", 0, "PF_Disp_action_up", [goUp, 3])
        this.menu.addChild("PF_Disp_Child", 1, "PF_Disp_True_Child", [goToParentChild, 0])
        this.menu.addChild("PF_Disp_Child", 2, "PF_Disp_Disp_Child", [goToParentChild, 1])


        this.menu.addChild("summery", 6, "F", [goToChild, 0])
        this.menu.addChild("F", 0, "F_Child", [showField], ['ROUND(Frequency,2)', 'ROUND(Voltage_L_N_Avg,2)', 'ROUND(Current_Avg,2)', 'ROUND(Power_Factor_Total,2)'], ['action_up', '', '', ''], ['Hz', 'V', 'A', 'Lead'], ['Freq', 'Vavg', 'Iavg', 'PF'], ['Frequency'])
        this.menu.addChild("F_Child", 0, "F_action_up", [goUp, 3])


        this.menu.addChild("summery", 7, "summery_action_right", [goRight, 4])

        this.menu.showfieldCount = 4;
        this.menu.activeChildPath = [0];
        this.menu.updateChild();
    }
}

class Menu {
    constructor(id, name, action = showField, field, downfield, unit, description, header, child) {
        this.id = id;
        this.name = name;
        this.field = field || null;
        this.action = action || null;
        this.downfield = downfield || null;
        this.unit = unit || null;
        this.description = description || null;
        this.header = header || null;
        this.children = child || [];
        this.lastIndex = 0;
        this.downFieldIndex = 0;
        this.showfieldCount = 4;
        this.activeChildPath = [];
        this.activeChild = [];
    }

    addChild(parentName, id, name, action = showField, field, downfield, unit, description, header) {
        if (parentName == null || parentName === this.name) {
            this.children.push(new Menu(id, name, action, field, downfield, unit, description, header));
        } else {
            for (let i = 0; i < this.children.length; i++)
                this.children[i].addChild(parentName, id, name, action, field, downfield, unit, description, header)
        }
    }

    getChild(offset = 0, path = this.activeChildPath) {
        let temp = this;
        for (let i = 0; i < path.length - offset; i++)
            temp = temp.children[path[i]];
        return temp;
    }

    nextChild(offset = 0, change = 1) {
        offset = offset + 1;
        let parent = this.getChild(offset)
        let pageI = parent.lastIndex + change;
        let pageMax = parent.children.length - 1;
        let pageMin = 0;
        if (pageI === pageMax + 1)
            pageI = pageMin;
        if (pageI === pageMin - 1)
            pageI = pageMax;
        parent.lastIndex = pageI;
        let tempChild = parent

        for (let i = offset; i > 0; i--) {
            this.activeChildPath[this.activeChildPath.length - i] = tempChild.lastIndex;
            this.activeChild = tempChild.children[tempChild.lastIndex];
            tempChild = parent.children[tempChild.lastIndex]
        }

        // return parent.children[parent.lastIndex];
    }

    childByNumber(offset = 0, number) {
        offset = offset + 1;

        let parent = this.getChild(offset)

        let pageMax = parent.children.length - 1;
        let pageMin = 0;

        if (number > pageMax || number < pageMin) {
            return null;
        }

        parent.lastIndex = number;

        let tempChild = parent

        for (let i = offset; i > 0; i--) {
            this.activeChildPath[this.activeChildPath.length - i] = tempChild.lastIndex;
            this.activeChild = tempChild.children[tempChild.lastIndex];
            tempChild = parent.children[tempChild.lastIndex]
        }

        // return parent.children[parent.lastIndex];
    }

    childChildByNumber(number) {
        let parent = this.getChild(0)

        let pageMax = parent.children.length - 1;
        let pageMin = 0;

        if (number > pageMax || number < pageMin) {
            return null;
        }

        parent.lastIndex = number;

        this.activeChildPath.push(parent.lastIndex);
        this.activeChild = parent.children[parent.lastIndex];

        // return parent.children[parent.lastIndex];
    }

    changeLevel(level) {
        for (let i = level; i > 0; i--) {
            this.activeChildPath.pop();
        }

        this.updateChild();
    }

    updateChild() {
        this.activeChild = this.getChild();
    }

    HandleAction() {
        let action = this.activeChild.action;
        let action_type = action[0]
        let action_value = action[1]
        switch (action_type) {
            case goToChild:
                this.childChildByNumber(action_value)
                this.HandleAction();
                break;
            case goToParentChild:
                this.changeLevel(2)
                this.childChildByNumber(action_value)
                this.HandleAction();
                break;
            case goUp:
                this.changeLevel(action_value);
                this.HandleAction();
                break;
            case goRight:
                this.changeLevel(1);
                this.activeChild.downFieldIndex += this.showfieldCount;
                if (this.activeChild.downFieldIndex >= this.activeChild.downfield.length)
                    this.activeChild.downFieldIndex = 0
                this.HandleAction();
                break;
            default:
                break;
        }
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
                                   style="font-size: 64px; color : #ff0000;margin: auto!important;direction: ltr!important;"></label> 
                        </div> 
                        <div class="row text-center" style="height: 93px;margin: auto!important;"> 
                            <label class="text-center showLabel2" 
                                   style="font-size: 64px; color : #ff0000;margin: auto!important;direction: ltr!important;"></label>
                        </div> 
                        <div class="row text-center" style="height: 93px;margin: auto!important;">
                            <label class="text-center showLabel3" 
                                   style="font-size: 64px; color : #ff0000;margin: auto!important;direction: ltr!important;"></label>
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
                                <i style="width: 10px;" onclick="device_class[%index].f1()" 
                                    class="fa fa-eye-slash"></i>
                            </button>
                            <button type="button" 
                                    style="position:absolute;color: transparent!important;padding: 15px!important;left: 130px;top: 25px;" 
                                    class="btn btn-link text-info" id="UPButt"><i 
                                    style="width: 10px;" 
                                    onclick="device_class[%index].f2()" 
                                    class="fa fa-eye-slash"></i>
                            </button>
                            <button type="button" 
                                    style="position:absolute;color: transparent!important;padding: 15px!important;left: 185px;top: 25px;" 
                                    class="btn btn-link text-info" id="OkBut">
                                    <i style="width: 10px;" onclick="device_class[%index].f3()" 
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
                    <div style="position: relative;width: 252px;height: 236px;margin: auto!important;top: 87px;"> 
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
                                   style="font-size: 18px; color : white;margin: auto!important;width: 200px;background-color: #3e454b;margin-bottom: unset!important;"></label> 
                        </div> 
                        
                        <div class="row text-center" style="height: 44px;margin: auto!important;">
                            <label class="text-center showLabel1 unitLabel" 
                                    style="font-size: 18px; color : #2a2f35;width: 63px;margin: auto!important;direction: ltr!important;"></label>
                            <label class="text-left showLabel1 valueLabel" 
                                    style="font-size: 32px; color : #2a2f35;width: 126px;margin: auto!important;direction: ltr!important;"></label> 
                            <label class="text-center showLabel1 desLabel" 
                                    style="font-size: 14px; color : #2a2f35;width: 63px;margin: auto!important;direction: ltr!important;"></label>
                        </div> 
                        <div class="row text-center" style="height: 44px;margin: auto!important;">
                            <label class="text-center showLabel2 unitLabel" 
                                    style="font-size: 18px; color : #2a2f35;width: 63px;margin: auto!important;direction: ltr!important;"></label>
                            <label class="text-left showLabel2 valueLabel" 
                                    style="font-size: 32px; color : #2a2f35;width: 126px;margin: auto!important;direction: ltr!important;"></label> 
                            <label class="text-center showLabel2 desLabel" 
                                    style="font-size: 14px; color : #2a2f35;width: 63px;margin: auto!important;direction: ltr!important;"></label>
                        </div> 
                        <div class="row text-center" style="height: 44px;margin: auto!important;">
                            <label class="text-center showLabel3 unitLabel" 
                                    style="font-size: 18px; color : #2a2f35;width: 63px;margin: auto!important;direction: ltr!important;"></label>
                            <label class="text-left showLabel3 valueLabel" 
                                    style="font-size: 32px; color : #2a2f35;width: 126px;margin: auto!important;direction: ltr!important;"></label> 
                            <label class="text-center showLabel3 desLabel" 
                                    style="font-size: 14px; color : #2a2f35;width: 63px;margin: auto!important;direction: ltr!important;"></label>
                        </div> 
                        <div class="row text-center" style="height: 44px;margin: auto!important;">
                            <label class="text-center showLabel4 unitLabel" 
                                    style="font-size: 18px; color : #2a2f35;width: 63px;margin: auto!important;direction: ltr!important;"></label>
                            <label class="text-left showLabel4 valueLabel" 
                                    style="font-size: 32px; color : #2a2f35;width: 126px;margin: auto!important;direction: ltr!important;"></label> 
                            <label class="text-center showLabel4 desLabel" 
                                    style="font-size: 14px; color : #2a2f35;width: 63px;margin: auto!important;direction: ltr!important;"></label>
                        </div> 
                      
                        <div class="row text-center" style="height: 28px;margin: auto!important;border-top: 2px solid #0c2920;"> 
                            <label class="text-center bottomFooter1" 
                                    style="position: absolute;left: 10px;font-size: 14px; color : #2a2f35;width: 50px;margin-top: unset!important;"></label> 
                            <label class="text-center bottomFooter2" 
                                    style="position: absolute;left: 70px;font-size: 14px; color : #2a2f35;width: 50px;margin-top: unset!important;"></label> 
                            <label class="text-center bottomFooter3" 
                                    style="position: absolute;left: 130px;font-size: 14px; color : #2a2f35;width: 50px;margin-top: unset!important;"></label> 
                            <label class="text-center bottomFooter4" 
                                    style="position: absolute;left: 190px;font-size: 14px; color : #2a2f35;width: 50px;margin-top: unset!important;"></label>
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

