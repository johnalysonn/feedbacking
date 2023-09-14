export function wait(timeMs){
    if(!timeMs){
        return 'data is not defined'
    }
    if(typeof(timeMs) != 'number'){
        return 'type data is not suported'
    }
    return new Promise(resolve => {
        setTimeout(resolve, timeMs);
    })
}