import { registerBlockType } from '@wordpress/blocks';
import {
  useBlockProps,
  InspectorControls,
  RichText,
  InnerBlocks
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
        date: '28/12/2009',
        time: '09h30',
        types: ['Pesquisa'],
        title: 'Edital nº 123'
      },
      {
        id: 2,
        date: '29/12/2009',
        time: '10h15',
        types: ['Ensino', 'Interno'],
        title: 'Edital nº 321'
      },
      {
        id: 3,
        date: '30/12/2009',
        time: '16h45',
        types: ['Extensão'],
        title: 'Edital nº 99'
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
            <RichText
              tagName="h2"
              className="ultimos-editais__title"
              value={title}
              onChange={(value) => setAttributes({ title: value })}
              placeholder="Insira o título"
              allowedFormats={[]}
            />
            {mockEditais.slice(0, postsPerPage).map((doc) => (
              <a key={doc.id} href="#" className="edital-recente">
                <div className="edital-recente__meta">
                  <p class="edital-recente__datetime">
                    {doc.date}
                    &agrave;s
                    {doc.time}
                  </p>

                  &bull;
                  <ul className="edital-recente__taxonomy-list">
                    {doc.types.map((type, idx) => (
                      <li key={idx}>{type}</li>
                    ))}
                  </ul>
                </div>
                <h3 className="edital-recente__title">
                  {doc.title}
                </h3>
              </a>
            ))}
          </div>

          <InnerBlocks
            allowedBlocks={['core/buttons']}
            template={[['core/buttons', { layout: { type: 'flex', justifyContent: 'center' } }, [['core/button', { className: 'is-style-outline', text: 'Acesse todos os Editais' }]]]]}
            templateLock="insert"
          />
        </div>
      </>
    );
  },

  save() {
    return null; // Renderizado no servidor
  },
});
