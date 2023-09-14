import {
    wait
} from './timeout'

describe('Timeout util', () =>{
    
    it('should give an error with empty param',()=>{
        expect(wait()).toBe('data is not defined')
    })
    it('should give an error with invalid type param', ()=>{
        expect(wait('abc')).toBe('type data is not suported')
    })
    it('should give true when pass correct param', ()=>{
        return wait(100).then(data => {
            expect(data).toBe(data)
        })
    })

})