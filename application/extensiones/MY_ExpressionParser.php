<?php

class MY_ExpressionParser 
{
	protected $valores;
	protected $lineno;
		
	public function parseAssignmentExpression($parser)
    {
       $targets = array();
	   $band = false;
        while (true) {
            $token = $parser->getStream()->expect(Twig_Token::NAME_TYPE, null);
			
            if (in_array($token->getValue(), array('true', 'false', 'none'))) {
                throw new Twig_Error_Syntax(sprintf('You cannot assign a value to "%s"', $token->getValue()), $token->getLine());
            }
			
            $targets[] = new Twig_Node_Expression_AssignName($token->getValue(), $token->getLine());
			
			if($parser->getStream()->test(Twig_Token::PUNCTUATION_TYPE, ':')) {
				$parser->getStream()->next();
				
				//$valor = $parser->getStream()->expect(Twig_Token::STRING_TYPE, null, 'Only variables can be assigned to');
				$this->valores[] = $parser->getStream()->expect(Twig_Token::STRING_TYPE, null, 'Only variables can be assigned to');
				//echo "VALOR: " . $valor;
				
				//$targets['valores'][] = new Twig_Node_Expression_AssignName($valor->getValue(), $valor->getLine());
				//die($parser->getStream());
				if($parser->getStream()->test(Twig_Token::BLOCK_END_TYPE)) {
					break;	
				}
				//die($valor->getValue());
			} 

			//$parser->getStream()->next();
            //$parser->getStream()->next();
        }

        return new Twig_Node($targets);
    }
	
	public function get_valores($parser) {
		$lineno = $parser->getCurrentToken()->getLine();
		
		return new Twig_Node($this->valores, array(), $lineno);
	}
}