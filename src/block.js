import { registerBlockType } from '@wordpress/blocks';
import {
  useBlockProps,
  InspectorControls
} from '@wordpress/block-editor';
import {
  PanelBody,
  TextControl,
} from '@wordpress/components';

registerBlockType('ifrs/ultimos-editais', {
  title: 'Últimos Editais',
  description: 'Bloco para exibir os últimos editais cadastrados ou atualizados.',
  icon: 'text-page',
  category: 'widgets',

  attributes: {
    title: { type: 'string', default: 'Últimos Editais' },
    postsPerPage: { type: 'number', default: 5 },
  },

  edit({ attributes, setAttributes }) {
    const { title, postsPerPage } = attributes;
    const blockProps = useBlockProps();

    // Dados mockados para o editor
    const mockEditais = [
      {
        id: 1,
        date: '22/01/2026',
        time: '14h30',
        types: ['Pesquisa'],
        title: 'Edital nº 123',
        link: '#'
      },
      {
        id: 2,
        date: '21/01/2026',
        time: '10h15',
        types: ['Ensino', 'Interno'],
        title: 'Edital nº 321',
        link: '#'
      },
      {
        id: 3,
        date: '20/01/2026',
        time: '16h45',
        types: ['Extensão'],
        title: 'Edital nº 99',
        link: '#'
      },
    ];

    return (
      <>
        <InspectorControls>
          <PanelBody title="Configurações" initialOpen={true}>
            <TextControl
              label="Título do Bloco"
              value={title}
              onChange={(value) => setAttributes({ title: value })}
            />
            <TextControl
              label="Quantidade de Documentos"
              type="number"
              value={postsPerPage}
              onChange={(value) => setAttributes({ postsPerPage: parseInt(value) })}
              min="1"
              max="50"
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div className="ultimos-editais">
            {title && (
              <h2 className="ultimos-editais__title">{title}</h2>
            )}
            {mockEditais.slice(0, postsPerPage).map((doc) => (
              <div key={doc.id} className="ultimos-editais__edital">
                <p className="ultimos-editais__edital-datetime">
                  {doc.date}
                  &agrave;s
                  {doc.time}
                </p>
                &bull;
                <ul className="ultimos-editais__edital-types">
                  {doc.types.map((type, idx) => (
                    <li key={idx}>{type}</li>
                  ))}
                </ul>
                <h3 className="ultimos-editais__edital-title">
                  <a href={doc.link}>{doc.title}</a>
                </h3>
              </div>
            ))}
          </div>

          <div className="acesso-todos-editals">
            <hr className="acesso-todos-editals__separador" />
            <a href="#" className="acesso-todos-editals__link">
              Acesse todos os Editais
            </a>
          </div>
        </div>
      </>
    );
  },

  save() {
    return null; // Renderizado no servidor
  },
});
