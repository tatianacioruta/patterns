<section id="content_area" xmlns:fb="http://www.w3.org/1999/html">
    <div class="clearfix wrapper main_content_area">
        <form name="calc" class="calc">
            <div class="display"><input type="text" readonly name="display" value=""></div>
            <br>

            <div class="keys">
                <div class="row1">
                    <input class="button gray" type="button" value="mrc" onclick="MemClear()">
                    <input class="button gray" type="button" value="m-" onclick="MemMinus()">
                    <input class="button gray" type="button" value="m+" onclick="MemPlus()">
                    <input class="button green" type="button" value="/" onclick="Operate('/')">
                    <input class="button green" type="button" value="EXP" onclick="DoExponent()">
                </div>
                <br>

                <div class="row2">
                    <input class="button black" type="button" value="7" onclick="AddDigit('7')">
                    <input class="button black" type="button" value="8" onclick="AddDigit('8')">
                    <input class="button black" type="button" value="9" onclick="AddDigit('9')">
                    <input class="button green" type="button" value="*" onclick="Operate('*')">
                    <input class="button green" type="button" value="X2" onclick="Pow2()">
                </div>
                <br>

                <div class="row3">
                    <input class="button black" type="button" value="4" onclick="AddDigit('4')">
                    <input class="button black" type="button" value="5" onclick="AddDigit('5')">
                    <input class="button black" type="button" value="6" onclick="AddDigit('6')">
                    <input class="button green" type="button" value="-" onclick="Operate('-')">
                    <input class="button green" type="button" value="Root" onclick="Root2()">
                </div>
                <br>

                <div class="row4">
                    <input class="button black" type="button" value="1" onclick="AddDigit('1')">
                    <input class="button black" type="button" value="2" onclick="AddDigit('2')">
                    <input class="button black" type="button" value="3" onclick="AddDigit('3')">
                    <input class="button green" type="button" value="+" onclick="Operate('+')">
                    <input class="button green" type="button" value="1/x" onclick="OneDivide()">
                </div>
                <br>

                <div class="row5">
                    <input class="button black" type="button" value="0" onclick="AddDigit('0')">
                    <input class="button black" type="button" value="." onclick="Dot()">
                    <input class="button black" type="button" value="C" onclick="AllClear()">
                    <input class="button orange" type="button" value="=" onclick="Calculate()">
                </div>
                <br>
            </div>
        </form>
    </div>
</section>
<style>
    .calc {
        background-color: #3d4543;
        height: 320px;
        width: 320px;
        border-radius: 10px;
        position: relative;
        left: 32%;

    }

    .display {
        background-color: #222;
        width: 285px;
        position: relative;
        left: 15px;
        top: 20px;
        height: 40px;
    }

    .display input {
        position: relative;
        left: 2px;
        top: 2px;
        height: 35px;
        color: black;
        background-color: tan;
        font-size: 21px;
        text-align: right;
        width: 280px;
    }

    .keys {
        position: relative;
        top: 15px;
    }

    .button {
        width: 40px;
        height: 30px;
        border: none;
        border-radius: 8px;
        margin-left: 17px;
        cursor: pointer;
        border-top: 2px solid transparent;
    }

    .button.gray {
        color: white;
        background-color: #6f6f6f;
        border-bottom: black 2px solid;
        border-top: 2px #6f6f6f solid;
    }

    .button.green {
        color: black;
        background-color: #88ff62;
        border-bottom: black 2px solid;
    }

    .button.black {
        color: white;
        background-color: #303030;
        border-bottom: black 2px solid;
        border-top: 2px #303030 solid;
    }

    .button.orange {
        color: black;
        background-color: #FF9933;
        border-bottom: black 2px solid;
        border-top: 2px #FF9933 solid;
        width: 95px;
    }

    .gray:active {
        border-top: black 2px solid;
        border-bottom: 2px #6f6f6f solid;
    }

    .green:active {
        border-top: black 2px solid;
        border-bottom: #ff4561 2px solid;
    }

    .black:active {
        border-top: black 2px solid;
        border-bottom: #303030 2px solid;
    }

    .orange:active {
        border-top: black 2px solid;
        border-bottom: #FF9933 2px solid;
    }

    p {
        line-height: 10px;
    }
</style>
<script>
    var Memory = "0";
    var Calc_Memory = "0";
    var Current = "0";
    var Operation = 0;
    var MAXLENGTH = 30;

    function MemPlus() {
        Calc_Memory = eval(Calc_Memory) + eval(Current);
        Calc_Memory = Calc_Memory.toString();
        Current = "0";
        document.calc.display.value = "";
    }
    function MemMinus() {
        Calc_Memory = eval(Calc_Memory) - eval(Current);
        Calc_Memory = Calc_Memory.toString();
        Current = "0";
        document.calc.display.value = "";
    }
    function MemClear() {
        document.calc.display.value = Calc_Memory;
        Current = "0";
        Calc_Memory = '0';

    }
    function AddDigit(dig) {
        if (Current.length > MAXLENGTH) {
            Current = "Aaaa! Too long";
        } else {
            if ((eval(Current) == 0)
                && (Current.indexOf(".") == -1)
            ) {
                Current = dig;
            } else {
                Current = Current + dig;
            }
        }
        document.calc.display.value = Current;
    }

    function Dot() {
        if (Current.length == 0) {
            Current = "0.";
        } else {
            if (Current.indexOf(".") == -1) {
                Current = Current + ".";
            }
        }
        document.calc.display.value = Current;
    }

    function Operate(op) {
        if (op.indexOf("*") > -1) {
            Operation = 1;
        }
        if (op.indexOf("/") > -1) {
            Operation = 2;
        }
        if (op.indexOf("+") > -1) {
            Operation = 3;
        }
        if (op.indexOf("-") > -1) {
            Operation = 4;
        }

        Memory = Current;
        Current = "";
        document.calc.display.value = Current;
    }

    function Calculate() {
        if (Operation == 1) {
            Current = eval(Memory) * eval(Current);
        }
        if (Operation == 2) {
            if (Current == '0') {
                document.calc.display.value = '0'
            } else {
                Current = eval(Memory) / eval(Current);
            }
        }
        if (Operation == 3) {
            Current = eval(Memory) + eval(Current);
        }
        if (Operation == 4) {
            Current = eval(Memory) - eval(Current);
        }
        Operation = 0;
        Memory = "0";
        Current = Current.toString();
        document.calc.display.value = Current;
    }

    function Pow2() {
        Current = eval(Current) * eval(Current);
        document.calc.display.value = Current;
    }
    function OneDivide() {
        if (Current == '0') {
            document.calc.display.value = '0'
        } else {
            Current = 1 / eval(Current);
        }
        document.calc.display.value = Current;
    }
    function Root2() {
        Current = eval(Current);
        Current = Math.sqrt(Current);
        document.calc.display.value = Current;
    }

    function AllClear() {
        Current = "0";
        Operation = 0;
        Memory = "0";
        document.calc.display.value = Current;
    }

    function DoExponent() {
        if (Current.indexOf("e") == -1) {
            Current = Current + "e0";
            document.calc.display.value = Current;
        }
        ;
    }
</script>