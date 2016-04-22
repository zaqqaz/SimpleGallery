AgentJAgent1 = function () {
    var o_this = this;

    o_this.isPresent = function () {
        try {
            if (jagentGetProtocolVersion() == 1) return true;
            return false;
        }
        catch (e) {
            return false;
        }
    }

    o_this.CallAnswer = function () {
        return false;
    }

    o_this.CallMake = function (in_callNumber) {
        jagentCallMake(in_callNumber);
        return true;
    }

    o_this.CallReady = function (interval) {
        return false;
    }

    o_this.CallRelease = function () {
        jagentCallRelease();
        return true;
    }

    o_this.CallSendDTMF = function (in_dtmf) {
        jagentCallSendDTMF(in_dtmf);
        return true;
    }

    o_this.CallSendDTMFEx = function (in_dtmf, in_toneDuration, in_pauseDuration) {
        return false;
    }

    o_this.CallTransferSS = function (in_callNumber) {
        jagentCallTransferSS(in_callNumber);
        return true;
    }

    o_this.CallTransferSSEx = function (in_callNumber, in_args) {
        return false;
    }

    o_this.CallTransferCCInit = function (in_callNumber) {
        // эмуляция
        jagentCallTransferCC();
        return true;
    }

    o_this.CallTransferCCInitEx = function (in_callNumber, in_args) {
        return false;
    }

    o_this.CallTransferCC = function () {
        //jagentCallTransferCC ();
        return false;
    }

    o_this.CallTransferCCAbort = function () {
        jagentCallTransferCCAbort();
        return true;
    }

    o_this.CallConferenceSS = function (in_callNumber) {
        return false;
    }

    o_this.CallConferenceCCInit = function (in_callNumber) {
        return false;
    }

    o_this.CallConferenceCC = function () {
        return false;
    }

    o_this.CallConferenceCCAbort = function () {
        return false;
    }

    o_this.CallSetInbound = function () {
        return false;
    }

    o_this.CallSetOutbound = function (in_scriptLink) {
        return false;
    }

    o_this.SetAutoAnswer = function (in_mode) {
        return false;
    }
}
AgentJAgent2 = function () {
    var o_this = this;

    o_this.isPresent = function () {
        try {
            if (jagentGetProtocolVersion() == 2) return true;
            return false;
        }
        catch (e) {
            return false;
        }
    }

    o_this.CallAnswer = function () {
        return jagentCallAnswer();
    }

    o_this.CallMake = function (in_callNumber) {
        var s = String(in_callNumber).replace(/[^0-9#\*]/g, '');
        return s ? jagentCallMake(s) : false;
    }

    o_this.CallReady = function (interval) {
        return jagentCallReady(interval);
    }

    o_this.CallRelease = function () {
        return jagentCallRelease();
    }

    o_this.CallSendDTMF = function (in_dtmf) {
        return jagentCallSendDTMF(in_dtmf);
    }

    o_this.CallSendDTMFEx = function (in_dtmf, in_toneDuration, in_pauseDuration) {
        return jagentCallSendDTMF(in_dtmf);
    }

    o_this.CallTransferSS = function (in_callNumber) {
        return jagentCallTransferSS(in_callNumber);
    }

    o_this.CallTransferSSEx = function (in_callNumber, in_args) {
        var args = o_this.JSONtoArrays(in_args);
        return jagentCallTransferSSEx(in_callNumber, args.keys, args.values);
    }

    o_this.CallTransferCCInit = function (in_callNumber) {
        return jagentCallTransferCCInit(in_callNumber);
    }

    o_this.CallTransferCCInitEx = function (in_callNumber, in_args) {
        var args = o_this.JSONtoArrays(in_args);
        return jagentCallTransferCCInitEx(in_callNumber, args.keys, args.values);
    }

    o_this.CallTransferCC = function () {
        return jagentCallTransferCC();
    }

    o_this.CallTransferCCAbort = function () {
        return jagentCallTransferCCAbort();
    }

    o_this.CallConferenceSS = function (in_callNumber) {
        return false;
    }

    o_this.CallConferenceCCInit = function (in_callNumber) {
        return jagentCallConferenceCCInit(in_callNumber);
    }

    o_this.CallConferenceCC = function () {
        return jagentCallConferenceCC();
    }

    o_this.CallConferenceCCAbort = function () {
        return jagentCallConferenceCCAbort();
    }

    o_this.CallSetInbound = function () {
        return jagentCallSetInbound();
    }

    o_this.CallSetOutbound = function (in_scriptLink) {
        return jagentCallSetOutbound(in_scriptLink);
    }

    o_this.CallPause = function (in_reason) {
        return jagentCallPause(in_reason);
    }

    o_this.SetAutoAnswer = function (in_mode) {
        return jagentSetAutoAnswer(in_mode);
    }

    o_this.JSONtoArrays = function (in_json) {
        var keys = [];
        var vals = [];

        for (var key in in_json) {
            keys.push(key);
            vals.push(in_json[key]);
        }

        return {"keys": keys, "values": vals};
    }
}
AgentNullAgent = function () {
    var o_this = this;

    o_this.isPresent = function () {
        return false;
    }

    o_this.CallAnswer = function () {
        return false;
    }

    o_this.CallMake = function (in_callNumber) {
        return false;
    }

    o_this.CallReady = function (interval) {
        return false;
    }

    o_this.CallRelease = function () {
        return false;
    }

    o_this.CallSendDTMF = function (in_dtmf) {
        return false;
    }

    o_this.CallSendDTMFEx = function (in_dtmf, in_toneDuration, in_pauseDuration) {
        return false;
    }

    o_this.CallTransferSS = function (in_callNumber) {
        return false;
    }

    o_this.CallTransferSSEx = function (in_callNumber, in_args) {
        return false;
    }

    o_this.CallTransferCCInit = function (in_callNumber) {
        return false;
    }

    o_this.CallTransferCCInitEx = function (in_callNumber, in_args) {
        return false;
    }

    o_this.CallTransferCC = function () {
        return false;
    }

    o_this.CallTransferCCAbort = function () {
        return false;
    }

    o_this.CallConferenceSS = function (in_callNumber) {
        return false;
    }

    o_this.CallConferenceCCInit = function (in_callNumber) {
        return false;
    }

    o_this.CallConferenceCC = function () {
        return false;
    }

    o_this.CallConferenceCCAbort = function () {
        return false;
    }

    o_this.CallSetInbound = function () {
        return false;
    }

    o_this.CallSetOutbound = function (in_scriptLink) {
        return false;
    }

    o_this.SetAutoAnswer = function (in_mode) {
        return false;
    }

    o_this.CallPause = function (in_reason) {
        return false;
    }
}
AgentProgrammaY = function () {
    var o_this = this;

    o_this.isPresent = function () {
        try {
            if (navigator.userAgent.indexOf("AppAgent") != -1)
                return true;
        }
        catch (e) {
        }
        return false;
    }

    o_this.CallAnswer = function () {
        return false;
    }

    o_this.CallMake = function (in_callNumber) {
        return window.external.CallMake(in_callNumber);
    }

    o_this.CallReady = function (interval) {
        return false;
    }

    o_this.CallRelease = function () {
        return window.external.CallRelease();
    }

    o_this.CallSendDTMF = function (in_dtmf) {
        return window.external.CallSendDTMF(in_dtmf);
    }

    o_this.CallSendDTMFEx = function (in_dtmf, in_toneDuration, in_pauseDuration) {
        return window.external.CallSendDTMFEx(in_dtmf, in_toneDuration, in_pauseDuration);
    }

    o_this.CallTransferSS = function (in_callNumber) {
        return window.external.CallTransferSS(in_callNumber);
    }

    o_this.CallTransferSSEx = function (in_callNumber, in_args) {
        return window.external.CallTransferSSEx(in_callNumber, in_args);
    }

    o_this.CallTransferCCInit = function (in_callNumber) {
        return window.external.CallTransferCCInit(in_callNumber);
    }

    o_this.CallTransferCCInitEx = function (in_callNumber, in_args) {
        return window.external.CallTransferCCInitEx(in_callNumber, in_args);
    }

    o_this.CallTransferCC = function () {
        return window.external.CallTransferCC();
    }

    o_this.CallTransferCCAbort = function () {
        return window.external.CallTransferCCAbort();
    }

    o_this.CallConferenceSS = function (in_callNumber) {
        return window.external.CallConferenceSS(in_callNumber);
    }

    o_this.CallConferenceCCInit = function (in_callNumber) {
        return window.external.CallConferenceCCInit(in_callNumber);
    }

    o_this.CallConferenceCC = function () {
        return window.external.CallConferenceCC();
    }

    o_this.CallConferenceCCAbort = function () {
        return window.external.CallConferenceCCAbort();
    }

    o_this.CallSetInbound = function () {
        return window.external.CallSetInbound();
    }

    o_this.CallSetOutbound = function (in_scriptLink) {
        return window.external.CallSetOutbound(in_scriptLink);
    }

    o_this.SetAutoAnswer = function (in_mode) {
        return false;
    }

}
/**
 * Сборщик AWI объекта. Определяет наличие агента и его тип.
 * ВАЖНО:
 * 1. Скрип должен быть загружен после скриптов реализующих доступы к своим агентам.
 * 2. Скрипт должен быть загружен до начала использования сторонним скриптом.
 * 3. Использовать для доступа к функциям агента только объект AGENT созданный этим скриптом.
 *    конструкция вида AGENT = new AgentJAgent2 () недопустима, так как скрипт после создания
 *    объекта расширяет его дополнительными методами isAgent() и getAgentId().
 *
 */
AGENT = {};
(function () {
    var nullAgent = new AgentNullAgent();
    var nullAgentId = "-1";

    var agents = new Object();
    agents["1"] = new AgentProgrammaY();
    agents["2"] = new AgentJAgent1();
    agents["3"] = new AgentJAgent2();
    //agents["4"] = new AgentJAgent2WebAccess ();
    //agents["5"] = new AgentJAgent2JFX ();

    var agent_id = getAgentId();
    updateAgent(agent_id);

    function updateAgent(in_agentId) {
        var is_agent = true;

        if (in_agentId == nullAgentId) {
            is_agent = false;
            AGENT = nullAgent;
        }
        else
            AGENT = agents[in_agentId];

        AGENT.isAgent = function () {
            return is_agent;
        }

        AGENT.getAgentId = function () {
            return in_agentId;
        }
    }

    function getAgentId() {
        for (var i in agents) {
            if (agents[i].isPresent())
                return i;
        }

        return nullAgentId;
    }
})();