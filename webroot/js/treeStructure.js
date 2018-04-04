
    function changeRights(Obj) {
        changeChild(Obj);
        changeParent(Obj);
    }
    function changeChild(Obj) {
        if (hasChild(Obj)) {
            var ObjChild = $(Obj).siblings('ul').children('li');
            for (var i = 0; i < ObjChild.length; i = i + 1) {
                var ObjInput = $(ObjChild[i]).children('input')[0];
                $(ObjInput).prop('checked', $(Obj).is(':checked'));
                changeChild(ObjInput);
            }
        }
    }
    function changeParent(Obj) {
        if (!hasParent(Obj))
            return;
        var AllSame = true;
        var HalfRight = false;
        var SiblingArr = $(Obj).parent('li').parent('ul').children('li');
        for (var i = 0; i < SiblingArr.length; i++) {
            var ObjInput = $(SiblingArr[i]).children('input')[0];
            if ($(ObjInput).is(':checked') !== $(Obj).is(':checked')) {
                AllSame = false;
                break;
            }
            if ($(ObjInput).prop('indeterminate')) {                
                HalfRight = true;
                break;
            }
        }

        var ObjParent = $(Obj).parent('li').parent('ul').siblings('input')[0];
        if (AllSame === true && HalfRight === false) {
            $(ObjParent).prop('indeterminate', false);
            $(ObjParent).prop('checked', $(Obj).is(':checked'));
        }
        else {
            $(ObjParent).prop('indeterminate', true);
            $(ObjParent).prop('checked', false);
        }
        changeParent(ObjParent);
    }
    function hasChild(Obj) {
        var ObjUl = $(Obj).siblings('ul');
        if (ObjUl == 'undefined' || ObjUl.length <= 0)
            return false;

        var ObjLi = $(ObjUl).children('li');
        if (ObjLi == 'undefined' || ObjLi.length <= 0)
            return false;

        for (var i = 0; i < ObjLi.length; i = i + 1) {
            var ObjInput = $(ObjLi[i]).children('input');
            if (ObjInput === 'undefined' || ObjInput.length <= 0) {
                alert('Hierarchy Problem.');
                return false;
            }
        }
        return true;
    }
    function hasParent(Obj) {
        var ObjLi = $(Obj).parent('li');
        if (ObjLi == 'undefined' || ObjLi.length <= 0)
            return false;

        var ObjUl = $(ObjLi).parent('ul');
        if (ObjUl == 'undefined' || ObjUl.length <= 0)
            return false;

        var ObjInput = $(ObjUl).siblings('input');
        if (ObjInput == 'undefined' || ObjInput.length <= 0)
            return false;

        return true;
    }
    

