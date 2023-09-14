import {
    validateEmptyAndLength3,
    validateEmptyAndEmail
} from './validators'

describe('Validators utils', () => {
    it('should give an error with empty payload', () => {
        expect(validateEmptyAndLength3()).toBe('*Este campo é obrigatório')
    })

    it('should give an error with less then 3 character payload', () => {
        expect(validateEmptyAndLength3('12')).toBe('*Este campo necessita de no mínimo de 3 caracteres')
    })

    it('should give true when pass input password correct param', ()=>{
        expect(validateEmptyAndLength3('1234')).toBe(true)
    })

    it('should give an error with empty payload', ()=>{
        expect(validateEmptyAndEmail()).toBe('*Este campo é obrigatório')
    })

    it('should give an error with invalid payload', () => {
        expect(validateEmptyAndEmail('123.com')).toBe('*Este campo precisa ser um e-mail')
    })
    it('should give true when pass input email correct param', () =>{
        expect(validateEmptyAndEmail('aaa123@gmail.com')).toBe(true)
    })
})