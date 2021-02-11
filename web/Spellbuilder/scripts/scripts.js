document.addEventListener('DOMContentLoaded', function () {
    if (!(document.getElementById("placeholderName") === null)) {
        document.getElementById("placeholderName").addEventListener("input", function () {
            document.getElementById("name").value = document.getElementById("placeholderName").value;
        });
    }

    if (!(document.getElementById("placeholderDesc") === null)) {
        document.getElementById("placeholderDesc").addEventListener("input", function () {
            document.getElementById("desc").value = document.getElementById("placeholderDesc").value;
        });
    }
});


function selectSpellAttr(classL, val) {
    //get the last class in the classList
    classL = classL[classL.length - 1];

    //get the element for the selected text
    var ele = document.getElementById(classL + "SelectedText");
    ele.textContent = val;

    //for damage/healing multipliers
    if (classL.toString().includes("effect")) {
        if (val == "Damage" || val == "Healing") {
            document.getElementsByClassName("bottom")[0].style.display = "grid";
        } else if (!(val.includes("*"))) {
            document.getElementsByClassName("bottom")[0].style.display = "none";
            document.getElementById("multiButtonSelectedText").textContent = "";
        }
    }

    calcCost();

}

function calcCost() {

    var cost = 0;
    var multi = 1;

    //caster type
    var casterType = document.getElementById("typeButtonSelectedText").textContent;
    if (casterType == "Full Caster") {
        cost += 2;
    } else if (casterType == "Half Caster") {
        cost += 1;
    }

    var castTime = document.getElementById("castButtonSelectedText").textContent;
    if (castTime == "Instant") {
        cost += 3;
    } else if (castTime == "6 Seconds") {
        cost -= 1;
    } else if (castTime == "12 Seconds") {
        cost -= 2;
    } else if (castTime == "1 Minute") {
        cost -= 3;
    } else if (castTime == "10 Minutes") {
        cost -= 4;
    } else if (castTime == "1 Hour") {
        cost -= 5;
    }

    var effectBase = document.getElementById("effectButtonSelectedText").textContent;
    if (effectBase == "Lesser") {
        cost += 1;
    } else if (effectBase == "Greater") {
        cost += 3;
        multi += 1.5;
    } else if (effectBase == "Supreme") {
        cost += 6;
        multi += 2;
    } else if (effectBase == "Wondrous") {
        cost += 13;
        multi += 2.5
    } else if (effectBase == "Legendary") {
        cost += 27;
        multi += 3;
    }

    var duration = document.getElementById("durationButtonSelectedText").textContent;
    if (duration == "30 Seconds") {
        cost += 3;
    } else if (duration == "1 Minute") {
        cost += 6
        multi += 1.5;
    } else if (duration == "10 Minutes") {
        cost += 3
        multi += 1.5;
    } else if (duration == "1 Hour") {
        cost += 6
        multi += 2;
    }

    var target = document.getElementById("targetButtonSelectedText").textContent;
    if (target == "1-3") {
        cost += 3
    } else if (target == "1-7") {
        cost += 6
        multi += 1.5;
    } else if (target == "5ft Area") {
        cost += 3
        multi += 1.5;
    } else if (target == "10ft Area") {
        cost += 6
        multi += 2;
    } else if (target == "20ft Area") {
        cost += 13
        multi += 1.5;
    } else if (target == "50ft Area") {
        cost += 27
        multi += 2;
    }

    var range = document.getElementById("rangeButtonSelectedText").textContent;
    if (range == "Self") {
        switch (casterType) {
            case "Full Caster":
                cost -= 6;
                break;
            case "Half Caster":
                cost -= 3;
                break;
            case "Melee Caster":
                cost -= 1;
                break;
        }
    } else if (range == "Melee") {
        switch (casterType) {
            case "Full Caster":
                cost -= 3;
                break;
            case "Half Caster":
                cost -= 1;
                break;
            case "Melee Caster":
                cost += 0;
                break;
        }
    } else if (range == "Short") {
        switch (casterType) {
            case "Full Caster":
                cost -= 1;
                break;
            case "Half Caster":
                cost += 0;
                break;
            case "Melee Caster":
                cost += 1;
                break;
        }
    } else if (range == "Medium") {
        switch (casterType) {
            case "Full Caster":
                cost += 0;
                break;
            case "Half Caster":
                cost += 1;
                break;
            case "Melee Caster":
                cost += 3;
                break;
        }
    } else if (range == "Long") {
        switch (casterType) {
            case "Full Caster":
                cost += 1;
                break;
            case "Half Caster":
                cost += 3;
                break;
            case "Melee Caster":
                cost += 6;
                break;
        }
    }

    var effectMulti = document.getElementById("multiButtonSelectedText").textContent;
    if (effectMulti == "*2") {
        cost += 1;
        multi += 1.5;
    } else if (effectMulti == "*3") {
        cost += 3;
        multi += 2;
    } else if (effectMulti == "*4") {
        cost += 6;
        multi += 2.5
    } else if (effectMulti == "*5") {
        cost += 13;
        multi += 3;
    }


    var total = Math.round(cost * multi);
    if (total < 0) {
        total = 0;
    }

    document.getElementById("costButtonSelectedText").textContent = total;

    setInputForm(casterType, total, castTime, effectBase, effectMulti, duration, target, range);

}

function setInputForm(casterType, totalCost, castTime, effectBase, effectMulti, duration, target, range) {

    document.getElementById("casterType").value = casterType;
    document.getElementById("cost").value = totalCost;
    document.getElementById("casttime").value = castTime;

    var multi = "";
    if (effectMulti != "") {
        multi = parseInt(effectMulti.toString().replace("*", ""));
    }
    document.getElementById("effects").value = effectBase;
    document.getElementById("durations").value = duration;
    document.getElementById("targets").value = target;
    document.getElementById("range").value = range;
    document.getElementById("multi").value = multi;

}